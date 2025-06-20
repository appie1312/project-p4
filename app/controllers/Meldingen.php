<?php

class Meldingen extends BaseController
{
    private $meldingenModel;

    public function __construct()
    {
        $this->meldingenModel = $this->model('MeldingenModel');
    }

    public function index()
    {
        $data = [
            'title' => 'Overzicht van meldingen',
            'meldingen' => $this->meldingenModel->getAllMeldingen()
        ];

        $this->view('meldingen/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Nieuwe melding toevoegen',
            'error' => '',
            'message' => 'none'
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if (empty($_POST['klantnummer']) || empty($_POST['type']) || empty($_POST['bericht'])) {
                $data['error'] = 'Vul alle velden in';
                $this->view('meldingen/create', $data);
                return;
            }

            if ($this->meldingenModel->create($_POST)) {
                $data['message'] = 'flex';
                $data['title'] = 'Melding succesvol toegevoegd';
                $_POST = [];
            } else {
                $data['error'] = 'Er ging iets mis bij het opslaan';
            }
        }

        $this->view('meldingen/create', $data);
    }

 

    public function delete($Id)
    {
        $result = $this->meldingenModel->delete($Id);
    
        if ($result) {
            // Succesmelding opslaan in session
            $_SESSION['success'] = "Melding succesvol verwijderd!";
        } else {
            $_SESSION['error'] = "Verwijderen is mislukt. Probeer het nog eens.";
        }
    sleep (2);

        header('Location: ' . URLROOT . '/meldingen/index');
        exit;
    }
    

    public function edit($id)
    {
        $melding = $this->meldingenModel->getMeldingById($id);

        if (!$melding) {
            die('Melding niet gevonden');
        }

        $data = [
            'title' => 'Melding bewerken',
            'melding' => $melding,
            'error' => ''
        ];

        $this->view('meldingen/edit', $data);
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if (
                empty($_POST['id']) ||
                empty($_POST['klantnummer']) ||
                empty($_POST['type']) ||
                empty($_POST['bericht'])
            ) {
                die('Vul alle velden in');
            }

            $this->meldingenModel->updateMelding($_POST);
            header('Location: ' . URLROOT . '/meldingen/index');
        } else {
            die('Ongeldige toegang');
        }
    }
}
