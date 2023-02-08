<?php

class Home extends Controller
{
    public function index()
    {
        $this->view('Home/index', 'Chilaw Pradeshiya Sabha');
    }

    public function homeTest()
    {
        $this->view('Home/homeTest', 'Home Test', [], ['main', 'home']);
    }  
}
