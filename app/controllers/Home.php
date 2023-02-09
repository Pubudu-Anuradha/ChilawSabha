<?php

class Home extends Controller
{
    public function index()
    {
        $this->view('Home/index', 'Chilaw Pradeshiya Sabha');
    }

    public function portal()
    {
        $this->view('Home/portal', 'Library Portal');
    }
}
