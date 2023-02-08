<?php

class Login extends Controller
{
    public function index()
    {
        $data = [];
        if (isset($_POST['Submit'])) {
            // Login submitted
            if (isset($_POST['email']) && isset($_POST['passwd'])) {
                $model = $this->model('LoginModel');
                $rows = $model->getUserCredentials($_POST['email']);
                if ($rows && ($rows->num_rows > 0)) {
                    $row = $rows->fetch_assoc();
                    $role = $row['role'];
                    if (password_verify($_POST['passwd'], $row['password_hash'])) {
                        $_SESSION['login'] = true;
                        $_SESSION['role'] = $row['role'];
                        $_SESSION['name'] = $row['first_name'] . ' ' . $row['last_name'];
                        header("location:" . URLROOT . "/$role");
                        die();
                    } else {
                        $data['wrongpass'] = 'Wrong Password';
                    }
                } else {
                    $data['nouser'] = 'No User with that password';
                }
            }
        }
        $this->view('Login/index', 'Login', $data);
    }

    public function passwordReset()
    {
        $this->view('Login/passwordReset', 'Reset Password');
    }

    public function Logout($redir = 'Home/index')
    {
        if (isset($_SESSION['login'])) {
            unset($_SESSION['login']);
        }

        if (isset($_SESSION['role'])) {
            unset($_SESSION['role']);
        }

        if (isset($_SESSION['name'])) {
            unset($_SESSION['name']);
        }

        header("location:$redir");
    }
}
