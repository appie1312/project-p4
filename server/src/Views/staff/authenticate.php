<?php
/**
 * Theater Aurora - Staff Authentication Endpoint
 * 
 * @package TheaterAurora
 * @version 1.0.0
 * @author SyncFocus17
 * @created 2025-05-21
 */

declare(strict_types=1);

// Start session with secure settings
ini_set('session.cookie_secure', '1');
ini_set('session.cookie_httponly', '1');
ini_set('session.use_strict_mode', '1');
ini_set('session.cookie_samesite', 'Lax');

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../config/bootstrap.php';

use App\Core\{
    Database,
    Security,
    Response,
    Logger
};
use App\Services\{
    AuthService,
    ActivityLogService,
    EmailService
};
use App\Exceptions\{
    AuthException,
    ValidationException,
    SecurityException
};

// Initialize response handler
$response = new Response();

try {
    // Verify request method
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new SecurityException('Invalid request method');
    }

    // Initialize services
    $auth = new AuthService();
    $security = new Security();
    $logger = new Logger('staff-auth');
    $activityLog = new ActivityLogService();

    // Start session securely
    session_start();

    // Verify CSRF token
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        throw new SecurityException('Invalid security token');
    }

    // Validate required fields
    $requiredFields = ['email', 'password'];
    foreach ($requiredFields as $field) {
        if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
            throw new ValidationException("Missing required field: {$field}");
        }
    }

    // Sanitize and validate input
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new ValidationException('Invalid email format');
    }

    $password = $_POST['password'];
    $rememberMe = isset($_POST['remember']) && $_POST['remember'] === 'on';

    // Get client information
    $clientData = [
        'ip' => $_SERVER['REMOTE_ADDR'],
        'user_agent' => $_SERVER['HTTP_USER_AGENT'],
        'timestamp' => date('Y-m-d H:i:s'),
        'request_id' => uniqid('auth_', true)
    ];

    // Log authentication attempt
    $logger->info('Authentication attempt', array_merge($clientData, ['email' => $email]));

    // Attempt authentication
    $authResult = $auth->authenticate($email, $password, 'staff', $rememberMe);

    // Handle 2FA if enabled
    if (isset($authResult['requires_2fa']) && $authResult['requires_2fa']) {
        $_SESSION['2fa_pending'] = true;
        $_SESSION['2fa_user_id'] = $authResult['user_id'];
        $_SESSION['2fa_temp_token'] = $authResult['temp_token'];

        $response->setStatusCode(202)
                ->setJsonContent([
                    'status' => 'pending_2fa',
                    'message' => 'Two-factor authentication required',
                    'redirect' => '/staff/2fa-verify'
                ])
                ->send();
        exit;
    }

    // Set secure session data
    $_SESSION['user'] = [
        'id' => $authResult['id'],
        'email' => $authResult['email'],
        'role' => $authResult['role'],
        'first_name' => $authResult['first_name'],
        'last_name' => $authResult['last_name'],
        'last_login' => $authResult['last_login']
    ];
    $_SESSION['auth_time'] = time();
    $_SESSION['last_activity'] = time();

    // Set remember me cookie if requested
    if ($rememberMe && isset($authResult['remember_token'])) {
        setcookie(
            'remember_token',
            $authResult['remember_token'],
            [
                'expires' => time() + (30 * 24 * 60 * 60), // 30 days
                'path' => '/',
                'domain' => '',
                'secure' => true,
                'httponly' => true,
                'samesite' => 'Strict'
            ]
        );
    }

    // Log successful authentication
    $activityLog->log('auth_success', array_merge($clientData, [
        'user_id' => $authResult['id'],
        'email' => $authResult['email'],
        'role' => $authResult['role']
    ]));

    // Check for password expiration
    if (isset($authResult['password_expires']) && strtotime($authResult['password_expires']) <= time()) {
        $_SESSION['password_expired'] = true;
        $response->setJsonContent([
            'status' => 'success',
            'message' => 'Authentication successful, but password needs to be updated',
            'redirect' => '/staff/change-password'
        ]);
    } else {
        // Determine redirect based on role
        $redirectUrl = match($authResult['role']) {
            'admin' => '/admin/dashboard',
            'manager' => '/staff/manager/dashboard',
            default => '/staff/dashboard'
        };

        $response->setJsonContent([
            'status' => 'success',
            'message' => 'Authentication successful',
            'redirect' => $redirectUrl
        ]);
    }

} catch (ValidationException $e) {
    $response->setStatusCode(422)
             ->setJsonContent([
                 'status' => 'error',
                 'message' => $e->getMessage(),
                 'errors' => $e->getErrors()
             ]);

    $logger->warning('Validation failed', [
        'error' => $e->getMessage(),
        'ip' => $_SERVER['REMOTE_ADDR']
    ]);

} catch (SecurityException $e) {
    $response->setStatusCode(403)
             ->setJsonContent([
                 'status' => 'error',
                 'message' => 'Security validation failed'
             ]);

    $logger->warning('Security check failed', [
        'error' => $e->getMessage(),
        'ip' => $_SERVER['REMOTE_ADDR']
    ]);

} catch (AuthException $e) {
    $response->setStatusCode(401)
             ->setJsonContent([
                 'status' => 'error',
                 'message' => 'Invalid credentials'
             ]);

    $logger->warning('Authentication failed', [
        'error' => $e->getMessage(),
        'ip' => $_SERVER['REMOTE_ADDR']
    ]);

} catch (\Throwable $e) {
    $response->setStatusCode(500)
             ->setJsonContent([
                 'status' => 'error',
                 'message' => 'An unexpected error occurred'
             ]);

    $logger->error('Unexpected error', [
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString(),
        'ip' => $_SERVER['REMOTE_ADDR']
    ]);

} finally {
    // Always send the response
    $response->send();

    // Clean up sensitive data
    unset($password, $_POST['password']);

    // Close database connection if open
    if (isset($db)) {
        $db = null;
    }
}