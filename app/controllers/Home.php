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
    
    public function emergency()
    {
        $data = ['emergency_details' => $this->model('EmergencyModel')->getAllEmergencyDetails()];
        $this->view('Home/emergency', 'Emergency Details', $data, ['main','emergency']);
    }

    public function bookRequest()
    {
        $this->view('Home/bookRequest', 'Book Request', [], ['main', 'libraryUsers']);
    }

    public function bookCatalogue()
    {
        $this->view('Home/bookCatalogue', 'Book Catalogue', [], ['main', 'libraryUsers']);
    }
}
