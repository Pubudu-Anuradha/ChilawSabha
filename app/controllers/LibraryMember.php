<?php

class LibraryMember extends Controller
{
    public function __construct()
    {
        $this->authenticateRole('LibraryMember');
    }
    public function index()
    {
        $this->view('LibraryMember/index');
    }
}
