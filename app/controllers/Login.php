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
                        if($user['user_type']==1){
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
        $this->view('Login/index', 'Login', $data,['login']);
    }

    public function passwordReset()
    {
        $data = [];
        if(isset($_POST['Submit'])){
            if(isset($_POST['resetCode']) && isset($_POST['forgot-email']) && isset($_POST['new-password']) && isset($_POST['confirm-password'])){
                $model = $this->model('LoginModel');
                $userCreds = $model->getPasswordResetCredentials($_POST['forgot-email']);
                $mail = $userCreds['result'][0]['email'];
                if ($userCreds && (!$userCreds['error'] && !$userCreds['nodata'])) {
                    $resetCode = $userCreds['result'][0]['password_reset_code'];
                    $resetTime = $userCreds['result'][0]['reset_code_time'];
                    date_default_timezone_set('Asia/Colombo');
                    $currentTime = date('Y-m-d H:i:s');
                    if($resetCode == $_POST['resetCode'] && $resetTime > $currentTime){
                        if($_POST['new-password'] == $_POST['confirm-password']){
                            $data = $model->changePassword();
                            if($data['resetPassword']){
                                $data['success'] = 'Password Changed Successfully';
                                unset($_POST['forgot-email']);
                                unset($_POST['resetCode']);
                                unset($_POST['Submit']);
                            }else{
                                $data['error'] = 'Password Change Failed';
                            }
                        }else{
                            $data['error'] = 'Passwords do not match';
                        }
                    }else{
                        $data['error'] = 'Invalid Reset Code';
                    }
                }else{
                    $data['error'] = 'Invalid Email';
                }
            }else{
                if(isset($_POST['Submit'])){
                    unset($_POST['Submit']);
                }
            }
        }else if(isset($_POST['resetCode'])){
            if(isset($_POST['forgot-email'])){
                $model = $this->model('LoginModel');
                $userCreds = $model->getPasswordResetCredentials($_POST['forgot-email']);
                $mail = $userCreds['result'][0]['email'];
                if ($userCreds && (!$userCreds['error'] && !$userCreds['nodata'])) {
                    $resetCode = rand(100000,999999);
                    date_default_timezone_set('Asia/Colombo');
                    $resetTimeFormat = mktime(
                        date('H'), date('i')+5, date('s'), date('m'), date('d'), date('Y')
                    );
                    $resetTime = date('Y-m-d H:i:s', $resetTimeFormat);
                    
                    $content = "<div class=\"main-container\" style=\"margin: 0; padding: 0; box-sizing: border-box; font-family: poppins; background-color: #ffffff;\">";
                    $content .= "<div class='logo-area' style=\"text-align: center; display: flex; align-items: center; justify-content: center; overflow-x: hidden;\">";
                    $content .= "<div class='logo-items' style=\"padding: 1rem; display: flex; gap: 20px; cursor:pointer;\" onclick='window.location.href= \"http://localhost/ChilawSabha/Home\"'>";
                    $content .= "<div class='logo'>";
                    $content .= "<img src=\"http://localhost/ChilawSabha/public/assets/logo.jpg\" height='100' width='90' alt='Sabha Logo'>";
                    $content .= "</div>
                                <div class='sabha-title' style=\"height: 100px; align-items: center;\">";
                    $content .= "<img src=\"http://localhost/ChilawSabha/public/assets/logo_text.png\" height='100' alt='Chilaw Pradeshiya Sabha'>";
                    $content .= "</div>";
                    $content .= "</div>";
                    $content .= "</div>
                                <div class='reset-content-div' style=\"margin: 5rem auto; padding: 2rem 2rem; width: 40rem; display:block; justify-content: center; align-items: center; border: 1px solid #93B4F2; background-color: #F0F5FE; border-radius: 1rem;\">"; 
                    $content .= "<h1 style=\"font-size: 2rem; font-weight: 700; color: #000000; margin-bottom: 2rem;\">User Password Reset</h1>
                                <p style=\"font-size: 1.2rem; font-weight: 500; color: #000000;\">
                                    Use following code to reset your password:
                                </p>
                        
                                <div class='reset-code' style=\"justify-content: center; align-items: center; box-sizing: border-box; text-align: center; width: fit-content; padding: 0.5rem 2rem; border-radius: 1rem; background-color: #93B4F2; margin: 1rem 3rem; color: #ffffff;\">
                                    <h2>$resetCode</h2>
                                </div>
                                
                                <p style=\"font-size: 1.2rem; font-weight: 500; color: #000000;\">If you don't use this code within 5 minutes, it will expire.<br/> 
                                To get a new password reset link,</p> <a href=\"http://localhost/ChilawSabha/Login/passwordReset\">
                                    Click Here!
                                </a><br/>
                                &nbsp;<br/>
                        
                                <p style=\"font-size: 1.2rem; font-weight: 500; color: #000000;\">Thanks,<br/>
                                Chilaw Pradeshiya Sabha </p>";
                    $content .= "</div>";
                    $content .= "</div>";
                    
                    
                    $model->setResetCode($mail, ['resetCode'=>$resetCode, 'resetTime'=>$resetTime]);
                    Email::send($mail, 'Password Reset', $content);


                }else if($userCreds['nodata']) {
                    $data['nouser'] = 'No User found with that email';
                } else {
                    $data['reseterr'] = 'Error while searching for user..! Please try again';
                }
            }else{
                if(isset($_POST['resetCode'])){
                    unset($_POST['resetCode']);
                }
            }
        }
        $this->view('Login/passwordReset', 'Reset Password', [], ['main', 'Components/form', 'login']);
    }

    public function codeTime(){
        $model = $this->model('LoginModel');
        $userCreds = $model->getPasswordResetCredentials($_POST['forgot-email']);
        $resetTime = $userCreds['result'][0]['reset_code_time'];
        $resetTime = strtotime($resetTime);
        $currentTime = time();
        $timeDiff = $resetTime-$currentTime;
        if($timeDiff >= 0){
            return $timeDiff;
        }else{
            unset($_POST['resetCode']);
        }
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

        header("location:$redirect");
    }
}
