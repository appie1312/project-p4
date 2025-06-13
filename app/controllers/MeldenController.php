<?php

class Melden extends BaseController
{

    public function index($firstname = NULL, $infix = NULL, $lastname = NULL)
    {
        /**
         * Het $data-array geeft informatie mee aan de view-pagina
         */


         $data = [
            'title' => 'Melden',
            'message' => '' 
        ];
        $this->view('melden/melden', $data);
        

    /**
     * De optellen-method berekent de som van twee getallen
     * We gebruiken deze method voor een unittest
     */
}
}
