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
    public function addComplaint()
    {
        $data = [];
        if (isset($_POST['submit'])) {
            // if (
            //     isset($_POST['nameInputField']) && !empty($_POST['nameInputField'])
            //     && isset($_POST['emailInputField']) && !empty($_POST['emailInputField'])
            //     && isset($_POST['phoneInputField']) && !empty($_POST['phoneInputField']) 
            //     && isset($_POST['addressInputField']) 
            //     && isset($_POST['selectOptionField']) 
            //     && isset($_POST['messageInputField'])
            //     && isset($_POST['dateInputField'])
            // ) {
            //     $model = $this->model('ComplaintModel');
            //     $res = $model->AddComplaint($_POST['nameInputField'], $_POST['emailInputField'], $_POST['phoneInputField'], $_POST['addressInputField'], $_POST['selectOptionField'], $_POST['messageInputField'], $_POST['dateInputField']);
            //     echo $res;
            //     if ($res) {
            //         $data['message'] = 'Added Complaint successfully';
            //     } else {
            //         $data['message'] = 'Failed to add Complaint';
            //     }
            // } else {
            //     $data['message'] = 'Invalid Parameters';
            // }

            var_dump($_POST);

            $validated = $this -> validateInputs($_POST,['nameInputField',
            'emailInputField',
            'phoneInputField',
            'addressInputField' ,
            'selectOptionField', 
            'messageInputField',
            'dateInputField'],'submit');
                var_dump($validated);
            if($validated){
                $model = $this->model('ComplaintModel');
                $data['AddComplaint']= $model -> AddComplaint($validated);
            }
        }

        $this->view('Complaint/addComplaint', 'Complaint',  $data , ['main', 'complaint']);
        
    //  $model = $this->model('ComplaintModel');
    //  $this->view('Complaint/addComplaint', 'Add Complaint',
    //  ['AddComplaint' => isset($_POST['submit']) ? $model->addComplaint($this->validateInputs($_POST, [
    //     'name', 'email', 'mobi_num', 'address', 'category', 'message','date',
    //  ], 'submit')) : null], ['main', 'complaint']);
     
    }

    // public function viewComplaint()
    // {
    //     $data = ['Complaints' => $this->model('ComplaintModel')->GetComplaint()];
    //     $this->view('ComplaintHandler/viewComplaint', $data);
    // }

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

    // public function addNote()
    // {
    //     $this->view('Complaint/addNote', 'Add Notes', [], ['main', 'complaint']);
    // }
}
