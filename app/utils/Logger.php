<?php
// Utils/Logger.php

class Logger {
    private $logFile = 'logs/app.log';

    public function __construct() {
        // Zorg ervoor dat de logs directory bestaat
        if (!file_exists('logs')) {
            mkdir('logs', 0777, true);
        }
    }

    public function log($message, $level = 'info') {
        $timestamp = date('Y-m-d H:i:s');
        $logMessage = "[$timestamp][$level] $message" . PHP_EOL;
        file_put_contents($this->logFile, $logMessage, FILE_APPEND);
    }
}