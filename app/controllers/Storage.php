<?php

class Storage extends Controller{
    public function __construct(){
        $this->authenticateRole('Storage');
    }

    public function index(){
        $this->view('Storage/index');
    }
}