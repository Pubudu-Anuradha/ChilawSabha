<?php

class Complaint extends Controller
{
    public function __construct()
    {
        $this->authenticateRole('Complaint');
    }
    public function index()
    {
        $this->view('Complaint/index', 'Complaint', [], ['main', 'complaint']);
    }
    
    public function addComplaint($page = 'index', $id = null)
    {
        
        
        $model = $this->model('ComplaintModel');
        $this->view('Complaint/addComplaint', 'Add Complaint',
        ['AddComplaint' => isset($_POST['submit']) ? $model->AddComplaint($this->validateInputs($_POST, [
            'name', 'email', 'phone_number', 'address', 'category', 'message',
        ], 'Submit')) : null], ['main', 'complaint']);
    }
   
    public function newComplaints()
    {
        $this->view('Complaint/newComplaints', 'New Complaints', [], ['main', 'complaint']);
    }

    public function allAcceptedComplaints()
    {
        $this->view('Complaint/allAcceptedComplaints', 'All Accepted Complaints', [], ['main', 'complaint']);
    }

    public function resolvedComplaints()
    {
        $this->view('Complaint/resolvedComplaints', 'Resolved Complaints', [], ['main', 'complaint']);
    }

    public function myWorkingComplaints()
    {
        $this->view('Complaint/myWorkingComplaints', 'My Working Complaints', [], ['main', 'complaint']);
    }

    public function myProcessingClickedComplaint()
    {
        $this->view('Complaint/myProcessingClickedComplaint', 'My Working Complaint', [], ['main', 'complaint']);
    }

    public function myResolvedClickedComplaint()
    {
        $this->view('Complaint/myResolvedClickedComplaint', 'My Resolved Complaint', [], ['main', 'complaint']);
    }

    public function newClickedComplaint()
    {
        $this->view('Complaint/newClickedComplaint', 'New Complaint', [], ['main', 'complaint']);
    }
    
    public function otherHandlerProcessingClickedComplaint()
    {
        $this->view('Complaint/otherHandlerProcessingClickedComplaint', 'Complaints', [], ['main', 'complaint']);
    }

    public function otherHandlerResolvedClickedComplaint()
    {
        $this->view('Complaint/otherHandlerResolvedClickedComplaint', 'Complaints', [], ['main', 'complaint']);
    }
}
