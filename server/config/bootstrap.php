<?php
if (file_exists(__DIR__ . '/../.env')) {
    $envFile = file_get_contents(__DIR__ . '/../.env');
    $lines = explode("\n", $envFile);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0 || empty(trim($line))) {
            continue;
        }
        list($name, $value) = explode('=', $line, 2);
        $_ENV[trim($name)] = trim($value);
        $_SERVER[trim($name)] = trim($value);
    }
}

define('APP_ROOT', dirname(__DIR__));
define('APP_VERSION', '1.0.0');
define('UPLOAD_PATH', APP_ROOT . '/storage/uploads');
define('LOG_PATH', APP_ROOT . '/storage/logs');