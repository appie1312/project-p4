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

    public function delete($Id)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        try {
            $result = $this->meldingenModel->delete($Id);
        
            if ($result) {
                $_SESSION['success'] = "Melding succesvol verwijderd!";
            } else {
                $_SESSION['error'] = "Verwijderen is mislukt. Probeer het nog eens.";
            }
        } catch (Exception $e) {
            $_SESSION['error'] = "Er ging iets mis bij het verwijderen.";
        }

        header('Location: ' . URLROOT . '/meldingen/index');
        exit;
    }

public function edit($id)
{
    $melding = $this->meldingenModel->getMeldingById($id);
    $data = ['melding' => $melding];
    $this->view('meldingen/update', $data);
}

public function update()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (
            empty($_POST['id']) ||
            empty($_POST['nummer']) ||
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