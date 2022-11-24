<?php

class Admin extends Controller
{
    public function __construct()
    {
        $this->authenticateRole('Admin');
    }

    public function index()
    {
        $this->view('Admin/index');
    }

    public function AddUser()
    {
        $data = [];
        if (isset($_POST['submit'])) {
            unset($_POST['submit']);
            $validated = $this->validateInputs($_POST, [
                'NIC', 'first_name', 'last_name', 'email', 'password', 'address', 'tel_no', 'role'
            ]);
            if (!$validated) {
                $data['message'] = 'Invalid Input Detected';
            } else {
                $model = $this->model('StaffUserModel');
                $res = $model->AddUser($validated);
                if ($res) {
                    $data['message'] = 'User Added Successfully';
                } else {
                    $data['message'] = 'Failed to Add User' . $res->error;
                }
            }
        }
        $this->view('Admin/AddUser', $data);
    }

    public function Users()
    {
        $data = ['users' => $this->model('StaffUserModel')->GetUsers()];
        $this->view('Admin/Users', $data);
    }
}
