<?php

class LibraryMember extends Controller
{
    public function __construct()
    {
        $this->authenticateRole('LibraryMember');
    }
    public function index()
    {
        $this->view('LibraryMember/index', 'Dashboard Library Member', [], ['main', 'libraryUsers']);
    }

    public function bookRequest()
    {
        $this->view('LibraryMember/bookRequest', 'Book Request', [], ['main', 'libraryUsers']);
    }

    public function bookCatalogue()
    {
        $this->view('LibraryMember/bookCatalogue', 'Book Catalogue', [], ['main', 'libraryUsers']);
    }

    public function planToRead()
    {
        $this->view('LibraryMember/planToRead', 'Plan to Read List', [], ['main', 'libraryUsers']);
    }

    public function favourite()
    {
        $this->view('LibraryMember/favourite', 'Favourite List', [], ['main', 'libraryUsers']);
    }

    public function completed()
    {
        $this->view('LibraryMember/completed', 'Completed List', [], ['main', 'libraryUsers']);
    }
}
