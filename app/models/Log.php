<?php
class Log {
    public function logScan($code, $result) {
        $logFile = __DIR__ . '/../logs/app.log';
        $line = "[" . date('Y-m-d H:i:s') . "] Code: $code, Resultaat: $result\n";
        file_put_contents($logFile, $line, FILE_APPEND);
    }
}