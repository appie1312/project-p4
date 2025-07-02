<?php

require_once __DIR__ . '/../models/Ticketmodel.php';

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

    public function delete($id)
    {
        try {
            if (!is_numeric($id)) {
                throw new Exception("Ongeldig ticket ID");
            }

            $result = $this->ticketModel->deleteTicket($id);
            if ($result) {
                header('Location: index.php?controller=ticket&action=index');
                exit;
            } else {
                throw new Exception("Fout bij verwijderen ticket");
            }
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

       
    public function create()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $data = [
            'nummer' => $_POST['Nummer'],
            'barcode' => $_POST['Barcode'],
            'voorstellingid' => $_POST['VoorstellingId'],
            'datum' => $_POST['Datum'],
            'tijd' => $_POST['Tijd'],
            'status' => $_POST['Status'],
            'bezoekerid' => $_POST['BezoekerId'],
            'prijsid' => $_POST['PrijsId']
        ];
        $this->ticketModel->createTicket($data);

        header('Location: ' . URLROOT . '/ticket/index');
        exit;
    } else {
        $data = [
            'title' => 'Ticket aanmaken',
            'message' => ''
        ];
        $this->view('ticket/create', $data);
    }
}

    public function addTicket($data)
{
    $sql = "INSERT INTO ticket (Nummer, Barcode, VoorstellingId, Datum, Tijd, Status, BezoekerId, PrijsId)
            VALUES (:Nummer, :Barcode, :VoorstellingId, :Datum, :Tijd, :Status, :BezoekerId, :PrijsId)";
    $this->db->query($sql);
    $this->db->bind(':Nummer', $data['Nummer']);
    $this->db->bind(':Barcode', $data['Barcode']);
    $this->db->bind(':VoorstellingId', $data['VoorstellingId']);
    $this->db->bind(':Datum', $data['Datum']);
    $this->db->bind(':Tijd', $data['Tijd']);
    $this->db->bind(':Status', $data['Status']);
    $this->db->bind(':BezoekerId', $data['BezoekerId']);
    $this->db->bind(':PrijsId', $data['PrijsId']);
    return $this->db->execute();
}

    public function edit($id)
    {
        if (!is_numeric($id)) {
            $error = "Ongeldig ticket ID";
            header('Location: index.php?controller=ticket&action=index');
            exit;
        }

        $ticket = $this->ticketModel->getTicketById($id);
        if (!$ticket) {
            $error = "Ticket niet gevonden";
            header('Location: index.php?controller=ticket&action=index');
            exit;
        }

        $data = [
            'title' => 'Ticket bewerken',
            'ticket' => (object)$ticket,
            'currentUser' => $this->currentUser,
            'currentDateTime' => $this->currentDateTime
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $result = $this->ticketModel->updateTicket($id, $_POST);
                if ($result) {
                    header('Location: index.php?controller=ticket&action=index');
                    exit;
                } else {
                    throw new Exception("Fout bij bijwerken ticket");
                }
            } catch (Exception $e) {
                $data['error'] = $e->getMessage();
            }
        }

        $this->view('ticket/edit', $data);
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['Id'];
            $result = $this->ticketModel->updateTicket($id, $_POST); // <-- aangepast
            if ($result) {
                // Redirect naar het overzicht
                header('Location: ' . URLROOT . '/ticket/index');
                exit;
            } else {
                // Toon eventueel een foutmelding
                $data = [
                    'error' => 'Fout bij het bijwerken van de ticket',
                    'ticket' => (object)$_POST,
                    'title' => 'ticket bewerken',
                    'message' => 'none'
                ];
                require_once __DIR__ . '/../views/ticket/edit.php';
            }
        }
    }

public function annuleerTicket($id) {
    try {
        $sql = "UPDATE Ticket SET Status = 'Geannuleerd' WHERE Id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    } catch (PDOException $e) {
        throw new Exception("Error annulleren ticket: " . $e->getMessage());
    }
}
    
}
