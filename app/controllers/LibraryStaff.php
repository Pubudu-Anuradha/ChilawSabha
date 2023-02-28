<?php

class LibraryStaff extends Controller
{
    public function __construct()
    {
        $this->authenticateRole('LibraryStaff');
    }

    public function index()
    {
        // TODO: USE COMPONENTS AND REDO
        $this->view('LibraryStaff/index',styles:['LibraryStaff/index']);
    }

    public function analytics()
    {
        $this->view('LibraryStaff/Analytics',styles:['LibraryStaff/analytics']);
    }
    
    public function bookcatalog()
    {
        // TODO: REDO USING COMPONENTS
        $this->view('LibraryStaff/Bookcatalog',styles:['LibraryStaff/catalogue']);
    }

    public function bookrequest()
    {
        // TODO: REDO USING COMPONENTS
        $this->view('LibraryStaff/Bookrequest');
    }

    public function lostbooks()
    {
        // TODO: REDO USING COMPONENTS
        $this->view('LibraryStaff/Lostbooks');
    }

    public function delistedbooks()
    {
        // TODO: REDO USING COMPONENTS
        $this->view('LibraryStaff/Delistedbooks');
    }

    public function damagedbooks()
    {
        // TODO: REDO USING COMPONENTS
        $this->view('LibraryStaff/Damagedbooks');
    }

    public function users()
    {
        // TODO: REDO USING COMPONENTS
        $this->view('LibraryStaff/Users');
    }

    public function disabledusers()
    {
        // TODO: REDO USING COMPONENTS
        $this->view('LibraryStaff/Disabledusers');
    }

    public function addusers()
    {
        // TODO: REDO USING COMPONENTS
        $this->view('LibraryStaff/Addusers');
    }

    public function addbooks()
    {
        // TODO: REDO USING COMPONENTS
        $this->view('LibraryStaff/Addbooks');
    }

    public function editbooks()
    {
        // TODO: REDO USING COMPONENTS
        $this->view('LibraryStaff/Editbooks');
    }

    public function editusers()
    {
        // TODO: REDO USING COMPONENTS
        $this->view('LibraryStaff/Editusers');
    }
}
