<?php

class ComplaintLogin extends Controller
{
    public function index()
    {
        $this->view('ComplaintLogin/Login');
    }

    public function ComplaintHandler()
    {
        $data = [];

        if (isset($_POST['login'])) {

            // Login submitted
            if (isset($_POST['email']) && isset($_POST['password'])) {
                $model = $this->model('ComplaintLoginModel');
                $rows = $model->getComplainHandlerCredentials($_POST['email']);
                var_dump($rows);
                if ($rows->num_rows > 0) {
                    $row = $rows->fetch_assoc();
                    var_dump($row);
                    $role = $row['role'];
                    if (password_verify($_POST['password'], $row['password_hash'])) {
                        $_SESSION['login'] = true;
                        $_SESSION['role'] = $row['role'];
                        header("location:" . URLROOT . "/$role");
                        die();
                    } else {
                        $data['message'] = 'wrongpass';
                    }
                } else {
                    $data['message'] = 'nouser';
                }
            }
        }
        $this->view('ComplaintLogin/Login', $data);
    }

    public function logout()
    {
        if (isset($_POST['logout'])) {
            var_dump($_POST);
            unset($_SESSION['login']);
            unset($_SESSION['role']);
            header('location:Home/index');
        }
        $this->view('ComplaintLogin/logout');
    }
}
