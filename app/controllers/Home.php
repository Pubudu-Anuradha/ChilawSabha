<?php

class Home extends Controller
{
    public function index()
    {
        $this->view('Home/index', 'Chilaw Pradeshiya Sabha');
    }

    public function emergency()
    {
        $this->view('Home/emergency', 'Emergency');
    }
}
