<?php

class Complaint extends Controller
{
    public function __construct()
    {
        $this->authenticateRole('Complaint');
    }
    public function index()
    {
        $this->view('Complaint/index', 'Complaint', styles: ['Complaint/dashboard', 'main']);
    }

    public function addComplaint()
    {
        $model = $this->model('ComplaintModel');
        $data = ['complaint_categories' => $model->get_categories()['result']];

        if (isset($_POST['Add'])) {

            [$valid, $err] = $this->validateInputs(
                $_POST,
                [
                    'name|l[:255]',
                    'email|l[:255]|e',
                    'contact_no|l[10:12]',
                    'address|l[:255]',
                    'category',
                    'description|l[:255]',
                    'date',
                ],
                'Add'
            );
            $data['errors'] = $err;

            $data['old'] = $_POST;
            $data = array_merge(count($err) > 0 ? ['errors' => $err] : ['Add' => $model->addComplaint($valid)], $data);
            $this->view('Complaint/addComplaint', 'Add New Complaint', $data, ['Components/form']);
        } else {
            $this->view('Complaint/addComplaint', 'Add New Complaint',  $data, styles: ['Components/form']);
        }
    }

    public function newComplaints()
    {
        $model = $this->model('ComplaintModel');

        $this->view('Complaint/newComplaints', 'New Complaints', [
            'newComplaints' => $model->get_new_complaints(), 'Category' => $model->get_categories(),
        ], styles: ['Complaint/complaint', 'Components/table', 'posts', 'Components/modal', 'main']);
    }

    public function allAcceptedComplaints()
    {
        $model = $this->model('ComplaintModel');
        $this->view('Complaint/allAcceptedComplaints', 'All Accepted Complaints', [
            'allComplaints' => $model->get_all_accepted_complaints()
        ], styles: ['Complaint/complaint', 'Components/table', 'posts', 'Components/modal', 'main']);
    }

    public function resolvedComplaints()
    {
        $model = $this->model('ComplaintModel');
        $this->view('Complaint/resolvedComplaints', 'Resolved Complaints', [
            'resolvedComplaints' => $model->get_resolved_complaints()
        ], styles: ['Complaint/complaint', 'Components/table', 'posts', 'Components/modal', 'main']);
    }

    public function myWorkingComplaints()
    {
        $model = $this->model('ComplaintModel');
        $this->view('Complaint/myWorkingComplaints', 'My Working Complaints', [
            'workingComplaints' => $model->get_working_complaints()
        ], styles: ['Complaint/complaint', 'Components/table', 'posts', 'Components/modal', 'main']);
    }

    public function viewComplaint($complaint_id)
    {
        $model = $this->model('ComplaintModel');
        $this->view('Complaint/viewComplaint', 'Complaint', [
            'viewComplaint' => $model->get_complaint($complaint_id), 'notes' => $model->get_notes($complaint_id)
        ], styles: ['Complaint/complaint', 'Components/table', 'posts', 'Components/modal', 'main']);
    }
}
