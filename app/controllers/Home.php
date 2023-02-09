<?php

class Home extends Controller
{
    public function index()
    {
        $this->view('Home/index', 'Chilaw Pradeshiya Sabha');
    }
    
    public function downloads()
    {
        $this->view('Home/downloads');
    }
}
