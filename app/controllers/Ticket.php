<?php

require_once __DIR__ . '/../models/ticketmodel.php';

class Ticket extends BaseController
{
    private $ticketModel;
    private $currentUser;
    private $currentDateTime;

    public function __construct()
    {
        $this->ticketModel = new TicketModel();
        $this->currentUser = 'jahir2004'; // In een echte app komt dit uit de sessie
        $this->currentDateTime = date('Y-m-d H:i:s');
    }

    public function index()
    {
        try {
            // Filters ophalen uit GET-parameters
            $filters = [
                'status' => $_GET['status'] ?? '',
                'voorstelling' => $_GET['voorstelling'] ?? '',
                'datum' => $_GET['datum'] ?? ''
            ];

            // Data ophalen via model
            $tickets = $this->ticketModel->getAllTickets($filters);
            $voorstellingen = $this->ticketModel->getVoorstellingen();

            // Viewdata klaarmaken
            $data = [
                'title' => 'Tickets',
                'tickets' => $tickets,
                'voorstellingen' => $voorstellingen,
                'currentUser' => $this->currentUser,
                'currentDateTime' => $this->currentDateTime,
                'filters' => $filters
            ];

            // View inladen
            $this->view('ticket/index', $data);
        } catch (Exception $e) {
            $data = [
                'title' => 'Tickets - Fout',
                'error' => $e->getMessage(),
                'currentUser' => $this->currentUser,
                'currentDateTime' => $this->currentDateTime
            ];

            $this->view('ticket/index', $data);
        }
    }
}
