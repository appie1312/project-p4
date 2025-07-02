<?php
require_once __DIR__ . '/../models/medewerkermodel.php';

class Medewerker {
    private $model;

    public function __construct() {
        $this->model = new MedewerkerModel();
    }

    public function index() {
        $medewerkers = $this->model->getAllMedewerkers();
        $error = null;
        $success = null;
        require_once __DIR__ . '/../views/medewerker/index.php';
    }

    public function view($id) {
        if (!is_numeric($id)) {
            $error = "Ongeldig medewerker ID";
            header('Location: index.php?controller=medewerker&action=index');
            exit;
        }
        $medewerker = $this->model->getMedewerkerById($id);
        if (!$medewerker) {
            $error = "Medewerker niet gevonden";
            header('Location: index.php?controller=medewerker&action=index');
            exit;
        }
        require_once __DIR__ . '/../views/medewerker/view.php';

        if (isset($_POST['delete'])) {
            $result = $this->model->deleteMedewerker($id);
            if ($result) {
                $success = "Medewerker succesvol verwijderd";
            } else {
                $error = "Fout bij verwijderen medewerker";
            }
            header('Location: index.php?controller=medewerker&action=index');
            exit;
        }
    }

    public function delete($id)
{
    if (!is_numeric($id)) {
        // Ongeldig ID, terug naar overzicht
        header('Location: ' . URLROOT . '/medewerker/index');
        exit;
    }

    try {
        $result = $this->model->deleteMedewerker($id);
        // Je kunt eventueel een succesmelding meegeven via een sessie of querystring
    } catch (Exception $e) {
        // Je kunt eventueel een foutmelding tonen
    }

    // Altijd terug naar het overzicht
    header('Location: ' . URLROOT . '/medewerker/index');
    exit;
}

    public function create() {
    $data = [
        'title' => 'Nieuwe medewerker toevoegen',
        'message' => 'none'
    ];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // ...verwerk je POST-data...
        if ($this->model->createMedewerker($_POST)) {
            $data['message'] = 'block'; // Toon succesmelding
        } else {
            $data['message'] = 'block'; // Of toon een foutmelding
        }
    }

    require_once __DIR__ . '/../views/medewerker/create.php';
}

    

public function edit($id = null) {
    if ($id === null || !is_numeric($id)) {
        $data = [
            'error' => "Ongeldig medewerker ID",
            'medewerkers' => $this->model->getAllMedewerkers()
        ];
        require_once __DIR__ . '/../views/medewerker/index.php';
        return;
    }

    $medewerker = $this->model->getMedewerkerById($id);
    if (!$medewerker) {
        $data = [
            'error' => "Medewerker niet gevonden",
            'medewerkers' => $this->model->getAllMedewerkers()
        ];
        require_once __DIR__ . '/../views/medewerker/index.php';
        return;
    }

    $data = [
        'medewerker' => (object)$medewerker, // <-- forceer naar object
        'title' => 'Medewerker bewerken',
        'message' => 'none'
    ];
    require_once __DIR__ . '/../views/medewerker/edit.php';
}

public function update()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['Id'];
        $result = $this->model->updateMedewerker($id, $_POST);
        if ($result) {
            // Redirect naar het overzicht
            header('Location: ' . URLROOT . '/medewerker/index');
            exit;
        } else {
            // Toon eventueel een foutmelding
            $data = [
                'error' => 'Fout bij het bijwerken van de medewerker',
                'medewerker' => (object)$_POST,
                'title' => 'Medewerker bewerken',
                'message' => 'none'
            ];
            require_once __DIR__ . '/../views/medewerker/edit.php';
        }
    }
}
}

