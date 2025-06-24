<?php

class melden extends BaseController
{
    private $meldenModel;

    public function __construct()
    {
        $this->meldenModel = $this->model('meldenModel');
    }

    public function index()
    {
        $data = [
            'title' => 'Probleem melden',
            'message' => 'none',
            'error' => ''
        ];

        $this->view('melden/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Nieuwe melding toevoegen',
            'message' => 'none',
            'error' => ''
        ];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if (empty($_POST['nummer']) || empty($_POST['type']) || empty($_POST['bericht'])) {
                $data['error'] = 'Vul alle velden in';
                $this->view('melden/index', $data);
                return;
            }

            $meldingData = [
                'nummer' => (int)$_POST['nummer'],
                'type' => $_POST['type'],
                'bericht' => $_POST['bericht'],
                'isactief' => 1,
                'opmerking' => $_POST['opmerking'] ?? null,
                'bezoekerId' => $_POST['bezoekerId'] ?? null,
                'medewerkerId' => $_POST['medewerkerId'] ?? null,
            ];

            $this->meldenModel->create($meldingData);

            $data['message'] = 'flex';
            $data['title'] = 'Melding succesvol toegevoegd';

            $_POST = [];

            $this->view('melden/index', $data);
            return;
        }

        $this->view('melden/index', $data);
    }
}
