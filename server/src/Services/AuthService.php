<?php

namespace App\Services;

use App\Core\Database;
use App\Core\Security;
use App\Core\Logger;
use App\Models\{User, StaffUser};
use App\Exceptions\{AuthException, SecurityException};
use App\Services\{EmailService, TokenService, ActivityLogService};

class AuthService {
    private Database $db;
    private Security $security;
    private Logger $logger;
    private EmailService $emailService;
    private TokenService $tokenService;
    private ActivityLogService $activityLog;
    
    private const TOKEN_EXPIRY = 3600;
    private const MAX_LOGIN_ATTEMPTS = 5;
    private const LOCKOUT_DURATION = 1800; 
    private const PASSWORD_RESET_EXPIRY = 7200; 
    private const SESSION_LIFETIME = 86400;
    private const REMEMBER_ME_DURATION = 2592000;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->security = new Security();
        $this->logger = new Logger('authentication');
        $this->emailService = new EmailService();
        $this->tokenService = new TokenService();
        $this->activityLog = new ActivityLogService();
    }

    public function authenticate(
        string $email,
        string $password,
        string $userType = 'staff',
        bool $remember = false
    ): array {
        try {
            // Check for rate limiting
            $this->checkRateLimiting($email);

            // Get user model based on type
            $userModel = $userType === 'staff' ? new StaffUser() : new User();
            
            // Find user
            $user = $userModel->findByEmail($email);
            if (!$user) {
                $this->handleFailedLogin($email, 'User not found');
                throw new AuthException('Invalid credentials');
            }

            // Check account status
            if (!$user['is_active']) {
                $this->handleFailedLogin($email, 'Account inactive');
                throw new AuthException('Account is not active');
            }

            // Verify password
            if (!$this->security->verifyPassword($password, $user['password'])) {
                $this->handleFailedLogin($email, 'Invalid password');
                throw new AuthException('Invalid credentials');
            }

            // Check if password needs rehashing
            if ($this->security->passwordNeedsRehash($user['password'])) {
                $userModel->updatePassword($user['id'], $this->security->hashPassword($password));
            }

            // Check if 2FA is enabled and validate if necessary
            if ($user['two_factor_enabled']) {
                return $this->initiate2FAAuthentication($user);
            }

            // Create session
            $sessionData = $this->createSession($user, $userType);

            // Handle "Remember Me"
            if ($remember) {
                $this->createRememberMeToken($user['id'], $userType);
            }

            // Log successful login
            $this->logSuccessfulLogin($user);

            // Reset failed login attempts
            $this->resetFailedAttempts($email);

            return array_merge($user, $sessionData);

        } catch (AuthException $e) {
            $this->logger->error('Authentication failed', [
                'email' => $email,
                'error' => $e->getMessage(),
                'ip' => $_SERVER['REMOTE_ADDR']
            ]);
            throw $e;
        }
    }

    /**
     * Verify two-factor authentication code
     */
    public function verify2FA(string $userId, string $code): bool {
        try {
            $user = $this->getUserById($userId);
            if (!$user || !$user['two_factor_secret']) {
                throw new AuthException('Invalid 2FA verification attempt');
            }

            return $this->security->verify2FACode($code, $user['two_factor_secret']);
        } catch (\Exception $e) {
            $this->logger->error('2FA verification failed', [
                'user_id' => $userId,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Initialize password reset process
     */
    
    public function initiatePasswordReset(string $email, string $userType = 'staff'): void {
        try {
            $user = $this->getUserByEmail($email, $userType);
            if (!$user) {
                // Don't reveal if email exists
                return;
            }

            $token = $this->tokenService->createPasswordResetToken($user['id']);
            $this->emailService->sendPasswordResetEmail($email, $token);

            $this->activityLog->log('password_reset_requested', [
                'user_id' => $user['id'],
                'email' => $email,
                'ip' => $_SERVER['REMOTE_ADDR']
            ]);
        } catch (\Exception $e) {
            $this->logger->error('Password reset initiation failed', [
                'email' => $email,
                'error' => $e->getMessage()
            ]);
            throw new AuthException('Unable to process password reset request');
        }
    }

    /**
     * Reset password using token
     */
    public function resetPassword(
        string $token,
        string $newPassword,
        string $userType = 'staff'
    ): bool {
        try {
            $tokenData = $this->tokenService->validatePasswordResetToken($token);
            if (!$tokenData) {
                throw new AuthException('Invalid or expired reset token');
            }

            $userModel = $userType === 'staff' ? new StaffUser() : new User();
            $hashedPassword = $this->security->hashPassword($newPassword);
            
            $userModel->updatePassword($tokenData['user_id'], $hashedPassword);
            $this->tokenService->invalidatePasswordResetToken($token);

            $this->activityLog->log('password_reset_completed', [
                'user_id' => $tokenData['user_id'],
                'ip' => $_SERVER['REMOTE_ADDR']
            ]);

            return true;
        } catch (\Exception $e) {
            $this->logger->error('Password reset failed', [
                'token' => substr($token, 0, 8) . '...',
                'error' => $e->getMessage()
            ]);
            throw new AuthException('Password reset failed');
        }
    }

    /**
     * Validate remember me token
     */
    public function validateRememberMeToken(string $token, string $userType = 'staff'): ?array {
        try {
            $tokenData = $this->tokenService->validateRememberMeToken($token);
            if (!$tokenData) {
                return null;
            }

            $user = $this->getUserById($tokenData['user_id'], $userType);
            if (!$user || !$user['is_active']) {
                return null;
            }

            // Rotate remember me token for security
            $newToken = $this->createRememberMeToken($user['id'], $userType);
            
            return [
                'user' => $user,
                'new_token' => $newToken
            ];
        } catch (\Exception $e) {
            $this->logger->error('Remember me token validation failed', [
                'token' => substr($token, 0, 8) . '...',
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Create and store a new session
     */
    private function createSession(array $user, string $userType): array {
        $sessionId = $this->security->generateSecureToken();
        $expiresAt = time() + self::SESSION_LIFETIME;

        $this->db->beginTransaction();
        try {
            $sql = "INSERT INTO user_sessions (user_id, session_id, user_type, ip_address, user_agent, expires_at)
                    VALUES (?, ?, ?, ?, ?, FROM_UNIXTIME(?))";
            
            $this->db->prepare($sql)->execute([
                $user['id'],
                $sessionId,
                $userType,
                $_SERVER['REMOTE_ADDR'],
                $_SERVER['HTTP_USER_AGENT'],
                $expiresAt
            ]);

            $this->db->commit();

            return [
                'session_id' => $sessionId,
                'expires_at' => $expiresAt
            ];
        } catch (\Exception $e) {
            $this->db->rollBack();
            throw new AuthException('Failed to create session');
        }
    }

    /**
     * Handle failed login attempt
     */
    private function handleFailedLogin(string $email, string $reason): void {
        $attempts = $this->incrementFailedAttempts($email);

        if ($attempts >= self::MAX_LOGIN_ATTEMPTS) {
            $this->lockAccount($email);
            $this->emailService->sendAccountLockedNotification($email);
        }

        $this->activityLog->log('login_failed', [
            'email' => $email,
            'reason' => $reason,
            'attempts' => $attempts,
            'ip' => $_SERVER['REMOTE_ADDR']
        ]);
    }

    /**
     * Check rate limiting
     */
    private function checkRateLimiting(string $email): void {
        $key = "login_attempts:{$email}";
        $attempts = $this->db->redis()->get($key) ?? 0;

        if ($attempts >= self::MAX_LOGIN_ATTEMPTS) {
            throw new AuthException('Too many login attempts. Please try again later.');
        }

        $this->db->redis()->incr($key);
        $this->db->redis()->expire($key, self::LOCKOUT_DURATION);
    }

    /**
     * Reset failed login attempts
     */
    private function resetFailedAttempts(string $email): void {
        $key = "login_attempts:{$email}";
        $this->db->redis()->del($key);
    }

    /**
     * Log successful login
     */
    private function logSuccessfulLogin(array $user): void {
        $this->activityLog->log('login_successful', [
            'user_id' => $user['id'],
            'email' => $user['email'],
            'ip' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT']
        ]);
    }

    /**
     * Initialize 2FA authentication
     */
    private function initiate2FAAuthentication(array $user): array {
        $tempToken = $this->tokenService->create2FAToken($user['id']);
        
        return [
            'requires_2fa' => true,
            'temp_token' => $tempToken,
            'user_id' => $user['id']
        ];
    }

    /**
     * Create remember me token
     */
    private function createRememberMeToken(int $userId, string $userType): string {
        $token = $this->security->generateSecureToken();
        $expiresAt = time() + self::REMEMBER_ME_DURATION;

        $this->tokenService->createRememberMeToken($userId, $token, $expiresAt, $userType);

        return $token;
    }
}