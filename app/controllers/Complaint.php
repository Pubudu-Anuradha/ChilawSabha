<?php

class Complaint extends Controller
{
    public function index()
    {
        $this->view('Complaint/dashboard');
    }
    public function addComplaint()
    {
        $data = [];
        if (isset($_POST['submit'])) {
            if (
                isset($_POST['name']) && !empty($_POST['name'])
                && isset($_POST['email']) && !empty($_POST['email'])
                && isset($_POST['mobi_num']) && !empty($_POST['mobi_num'])
                && isset($_POST['address']) && isset($_POST['category']) && isset($_POST['message'])
                && isset($_POST['date']) && !empty($_POST['date'])
            ) {
                $model = $this->model('ComplaintModel');
                $res = $model->AddComplaint($_POST['name'], $_POST['email'], $_POST['mobi_num'], $_POST['address'], $_POST['category'], $_POST['message'], $_POST['date']);
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

        $this->view('Complaint/addComplaint', $data);
    }
    public function newComplaints()
    {
        $data = ['Complaints' => $this->model('ComplaintModel')->GetComplaint()];
        $this->view('Complaint/newComplaints', $data);
    }
}
