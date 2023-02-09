<?php

class LibraryStaff extends Controller
{
    public function __construct()
    {
        $this->authenticateRole('LibraryStaff');
    }

    public function index()
    {
        $this->view('LibraryStaff/index');
    }

    public function analytics()
    {
        $this->view('LibraryStaff/Analytics');
    }
    
    public function bookcatalog()
    {
        $this->view('LibraryStaff/Bookcatalog');
    }

    public function bookrequest()
    {
        $this->view('LibraryStaff/Bookrequest');
    }

    public function lostbooks()
    {
        $this->view('LibraryStaff/Lostbooks');
    }

    public function delistedbooks()
    {
        $this->view('LibraryStaff/Delistedbooks');
    }

    public function damagedbooks()
    {
        $this->view('LibraryStaff/Damagedbooks');
    }

    public function users()
    {
        $this->view('LibraryStaff/Users');
    }

    public function disabledusers()
    {
        $this->view('LibraryStaff/Disabledusers');
    }

    public function addusers()
    {
        $this->view('LibraryStaff/Addusers');
    }

    public function addbooks()
    {
        $this->view('LibraryStaff/Addbooks');
    }

    public function editbooks()
    {
        $this->view('LibraryStaff/Editbooks');
    }

    public function editusers()
    {
        $this->view('LibraryStaff/Editusers');
    }
}
