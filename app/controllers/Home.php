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

    public function portal()
    {
        $this->view('Home/portal', 'Library Portal');
    }
}
