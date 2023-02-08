<?php

class Login extends Controller
{
    public function index()
    {
        $data = [];
        if (isset($_POST['Submit'])) {
            // Login submitted
            if (isset($_POST['email']) && isset($_POST['passwd'])) {
                // Get User Login Model
                $model = $this->model('LoginModel');
                $userCreds = $model->getUserCredentials($_POST['email']);

                if ($userCreds && (!$userCreds['error'] && !$userCreds['nodata'])) {
                    // User with email exists
                    $user = $userCreds['result'][0];
                    if (password_verify($_POST['passwd'], $user['password_hash'])) {
                        // Password matches stored hash.. Determining UserRole
                        // If not staff member, Default to LibraryMember
                        $role = 'LibraryMember';
                        if($user['type']=='Staff'){
                            $staffUser = $model->getStaffRole($_POST['email']); 
                            $role = $staffUser['result'][0]['role'];
                        }
                        // Set session Variables
                        $_SESSION['login'] = true;
                        $_SESSION['role'] = $role;
                        $_SESSION['name'] = $user['name'];
                        header("location:" . URLROOT . "/$role");
                        die();
                    } else {
                        $data['wrongpass'] = 'Wrong Password';
                    }
                } else if($userCreds['nodata']) {
                    $data['nouser'] = 'No User with that password';
                } else {
                    $data['logerr'] = 'Login Error';
                }
            }
        }
        $this->view('Login/index', 'Login' ,$data);
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
