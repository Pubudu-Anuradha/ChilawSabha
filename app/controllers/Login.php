<?php

class Login extends Controller
{
    public function index()
    {
        if ($_SESSION['login'] ?? false) {
            $role = $_SESSION['role'] ?? false;
            if (!$role) {
                $this->Logout();
            } else {
                header("location:" . URLROOT . "/$role");
            }
            die();
        }
        $data = [];
        if (isset($_POST['Login'])) {
            // Login submitted
            [$validated, $errors] = $this->validateInputs($_POST, [
                'email|e|l[:255]', 'passwd',
            ], 'Login');
            $data['old'] = $_POST;
            $data['errors'] = $errors;
            if (count($errors) == 0) {
                $model = $this->model('LoginModel');
                $userCredentials = $model->getUserCredentials($validated['email']);
                if (!$userCredentials['error']) {
                    if (!$userCredentials['nodata']) {
                        // User with email exists
                        $user = $userCredentials['result'][0];
                        $data['user'] = $user;
                        $user_active = [
                            1 => true,
                            2 => false
                        ][$user['state_id']] ?? false;
                        
                        if($user_active){
                            if (password_verify($validated['passwd'], $user['password_hash'])) {
                                // Password matches stored hash.. Determining UserRole
                                // If not staff member, Default to LibraryMember
                                $role = false;
                                if ($user['user_type'] === 1) {
                                    $staffUser = $model->getStaffRoleId($validated['email']);
                                    if (!$staffUser || $staffUser['error'] ?? false) {
                                        // Should Never happen
                                        $data['errors']['login error'] = true;
                                    } else {
                                        $role = [
                                            1 => 'Admin',
                                            2 => 'LibraryStaff',
                                            3 => 'Complaint',
                                            4 => 'Storage',
                                        ][$staffUser['result'][0]['type_id']] ?? false;
                                    }
                                } else if ($user['user_type'] == 2) {
                                    $role = 'LibraryMember';
                                }
                                if (!$role) {
                                    // Should Never happen
                                    $data['errors']['login error'] = true;
                                } else {
                                    // Set session Variables
                                    $_SESSION['login'] = true;
                                    $_SESSION['role'] = $role;
                                    $_SESSION['email'] = $user['email'];
                                    $_SESSION['user_id'] = $user['user_id'];
                                    $_SESSION['name'] = $user['name'];
                                    header("location:" . URLROOT . "/$role");
                                    die();
                                }
                            } else {
                                $data['errors']['password match'] = $validated['passwd'];
                            }
                        }else{
                            $data['errors']['disabled'] = true;
                        }
                    } else {
                        $data['errors']['no email'] = $validated['email'];
                    }
                } else {
                    $data['errors']['login error'] = true;
                }
            }
        }
        $this->view('Login/index', 'Login', $data, ['login']);
    }

    public function passwordReset()
    {
        $this->view('Login/passwordReset', 'Reset Password', [], ['login']);
    }

    public function Logout($redirect = 'Home/index')
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

        if (isset($_SESSION['email'])) {
            unset($_SESSION['email']);
        }

        if (isset($_SESSION['user_id'])) {
            unset($_SESSION['user_id']);
        }

        header("location:$redirect");
        die();
    }
}
