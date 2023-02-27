<?php

class Home extends Controller
{
    public function index()
    {
        $this->view('Home/index', 'Chilaw Pradeshiya Sabha',styles:['Home/index','Components/slideshow']);
    }
    
    public function downloads()
    {
        $this->view('Home/downloads',styles:['Home/downloads']);
    }
    
    public function emergency()
    {
        $data = ['emergency_details' => $this->model('EmergencyModel')->getAllEmergencyDetails()];
        $this->view('Home/emergency', 'Emergency Details', $data, ['main','emergency']);
    }

    public function portal()
    {
        // TODO: Add Pictures of Library
        $this->view('Home/portal', 'Library Portal',styles:['Home/portal','slideshow']);
    }

    public function bookRequest()
    {
        // TODO: Use Form Input components
        $this->view('Home/bookRequest', 'Book Request', [], ['form']);
    }

    public function bookCatalogue()
    {
        // TODO: Use table component and Pagination components
        $this->view('Home/bookCatalogue', 'Book Catalogue', [], ['table']);
    }
    public function addComplaint()
    {
        // TODO: Use Form Input components
        $this->view('Home/AddComplaint', 'Complaint Form',$data=[],['main','Components/form']);
    }
}
