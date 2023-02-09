<?php

class Complaint extends Controller
{
    public function index()
    {
        $this->view('Complaint/index', 'Complaint', [], ['main', 'complaint']);
    }
    public function addComplaint()
    {
        $data = [];
        if (isset($_POST['submit'])) {
            if (
                isset($_POST['name']) && !empty($_POST['name'])
                && isset($_POST['email']) && !empty($_POST['email'])
                && isset($_POST['mobi_num']) && !empty($_POST['mobi_num']) && isset($_POST['address']) && isset($_POST['category']) && isset($_POST['message'])
            ) {
                $model = $this->model('ComplaintModel');
                $res = $model->AddComplaint($_POST['name'], $_POST['email'], $_POST['mobi_num'], $_POST['address'], $_POST['category'], $_POST['message']);
                echo $res;
                if ($res) {
                    $data['message'] = 'Added Complaint successfully';
                } else {
                    $data['message'] = 'Failed to add Complaint';
                }
            } else {
                $data['message'] = 'Invalid Parameters';
            }
        }

        $this->view('Complaint/addComplaint', 'Complaint', [], ['main', 'complaint'], $data);
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
}
