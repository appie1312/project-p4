<?php
namespace App\Core;

class Session {
    private static ?Session $instance = null;
    private bool $isStarted = false;

    private function __construct() {
        $this->start();
    }

    public static function getInstance(): Session {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function start(): void {
        if ($this->isStarted) {
            return;
        }

        if (session_status() === PHP_SESSION_NONE) {
            ini_set('session.cookie_httponly', '1');
            ini_set('session.cookie_secure', '1');
            ini_set('session.use_strict_mode', '1');
            ini_set('session.cookie_samesite', 'Lax');
            
            session_start();
            $this->isStarted = true;
        }
    }

    public function get(string $key, mixed $default = null): mixed {
        return $_SESSION[$key] ?? $default;
    }

    public function set(string $key, mixed $value): void {
        $_SESSION[$key] = $value;
    }

    public function remove(string $key): void {
        unset($_SESSION[$key]);
    }

    public function has(string $key): bool {
        return isset($_SESSION[$key]);
    }

    public function getFlash(string $key = null, mixed $default = null): mixed {
        if ($key === null) {
            $flash = $_SESSION['_flash'] ?? [];
            unset($_SESSION['_flash']);
            return $flash;
        }
        
        $value = $_SESSION['_flash'][$key] ?? $default;
        unset($_SESSION['_flash'][$key]);
        return $value;
    }

    public function setFlash(string $key, mixed $value): void {
        $_SESSION['_flash'][$key] = $value;
    }

    public function regenerate(): bool {
        return session_regenerate_id(true);
    }

    public function destroy(): bool {
        if ($this->isStarted) {
            session_destroy();
            $this->isStarted = false;
            return true;
        }
        return false;
    }
}