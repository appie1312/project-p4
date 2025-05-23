<?php
require_once __DIR__ . '/../models/ticketmodel.php';
class TicketController {
    private $ticketModel;
    private $currentUser;
    private $currentDateTime;

    public function __construct() {
        $this->ticketModel = new TicketModel();
        $this->currentUser = 'jahir2004'; // In een echte applicatie zou dit uit de sessie komen
        $this->currentDateTime = date('Y-m-d H:i:s');
    }

    public function index() {
        try {
            // Haal filter parameters op
            $filters = [
                'status' => $_GET['status'] ?? '',
                'voorstelling' => $_GET['voorstelling'] ?? '',
                'datum' => $_GET['datum'] ?? ''
            ];

            // Haal data op via het model
            $tickets = $this->ticketModel->getAllTickets($filters);
            $voorstellingen = $this->ticketModel->getVoorstellingen();

            // Bereid data voor voor de view
            $viewData = [
                'tickets' => $tickets,
                'voorstellingen' => $voorstellingen,
                'currentUser' => $this->currentUser,
                'currentDateTime' => $this->currentDateTime,
                'filters' => $filters
            ];

            // Toon de view
            $this->loadView('ticket/index', $viewData);

        } catch (Exception $e) {
            $viewData = [
                'error' => $e->getMessage(),
                'currentUser' => $this->currentUser,
                'currentDateTime' => $this->currentDateTime
            ];
            $this->loadView('ticket/index', $viewData);
        }
    }

    private function loadView($viewName, $data) {
        // Extract data zodat het beschikbaar is in de view
        extract($data);
        
        // Include de view file
        require_once __DIR__ . "/../views/{$viewName}.php";
    }
}