<?php
require_once __DIR__ . '/../models/Ticketscan.php';
require_once __DIR__ . '/../models/Log.php';

class Ticketscan {
    public function scan() {
        require __DIR__ . '/../views/ticketscan/scan.php';
    }

    public function validate() {
        try {
            $code = $_POST['code'] ?? '';
            if (empty($code)) {
                throw new Exception("Geen code ontvangen.");
            }
            $ticketModel = new Ticket();
            $isValid = $ticketModel->validateTicket($code);

            $logModel = new Log();
            $logModel->logScan($code, $isValid ? 'OK' : 'FAIL');

            $message = $isValid ? "Ticketscan is gelukt!" : "Ongeldig ticket.";
            $status = $isValid ? "success" : "error";
        } catch (Exception $e) {
            $message = $e->getMessage();
            $status = "error";
        }
        require __DIR__ . '/../views/ticketscan/result.php';
    }
}