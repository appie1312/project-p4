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
    }
}