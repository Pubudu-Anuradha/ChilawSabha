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
        $data = [];
        $data['auth-status'] = false;
        if(isset($_POST['Submit'])){
            $data['auth-status'] = true;
            if(!empty($_POST['reset-code-text']) && !empty($_POST['forgot-email']) && !empty($_POST['new-password']) && !empty($_POST['confirm-password'])){
                $model = $this->model('LoginModel');
                $userCreds = $model->getPasswordResetCredentials($_POST['forgot-email']);
                if ($userCreds && (!$userCreds['error'] && !$userCreds['nodata'])) {
                    if($_POST['forgot-email'] == $userCreds['result'][0]['email']){
                        $data['mail'] = $_POST['forgot-email'];
                        $resetCode = $userCreds['result'][0]['password_reset_code'];
                        $resetTime = $userCreds['result'][0]['reset_code_time'];
                        date_default_timezone_set('Asia/Colombo');
                        $currentTime = date('Y-m-d H:i:s');
                        if($resetCode == $_POST['reset-code-text'] && $resetTime > $currentTime){
                            $data['resetCode'] = $_POST['reset-code-text'];
                            if($_POST['new-password'] == $_POST['confirm-password'] && $data['auth-status']){ 
                                if($model->changePassword($data['mail'], $_POST['new-password'])){
                                    $data['change-success'] = 'Password Changed Successfully';
                                    unset($_POST['Submit']);
                                    $model->removeResetDetails($data['mail']);
                                    $this->view('Login/index', 'Login', $data,['login']);
                                }else{
                                    $data['change-error'] = 'Password Change Failed';
                                }
                            }else{
                                $data['password-unmatch'] = 'Passwords do not match';
                            }
                        }else if($resetTime <= $currentTime){
                            $data['reset-time-err'] = 'Reset code time has been expired!';
                            $data['mail-success'] = '';
                            $data['auth-status'] = false;

                        }else{
                            $data['reset-code-unmatch'] = 'Invalid Reset Code';
                            $data['auth-status'] = false;
                        }
                    }else{
                        $data['reset-mail-unmatch'] = 'Invalid Email Address';
                        $data['auth-status'] = false;
                    }
                }else if($userCreds['nodata']) {
                    $data['submit-err'] = 'Submit failed.!! Try again';
                    $data['mail-success'] = '';
                    $data['auth-status'] = false;
                } else {
                    $data['reset-auth-err'] = 'Error occurred..! Please try again';
                    $data['auth-status'] = false;
                }
            }else {
                if(empty($_POST['forgot-email'])){
                    $data['no-email'] = 'Please enter your email address';
                    $data['auth-status'] = false;
                }
                if(empty($_POST['reset-code-text'])){
                    $data['no-code'] = 'Please enter the reset code';
                    $data['auth-status'] = false;
                }
                if(empty($_POST['new-password'])){
                    $data['mail'] = $_POST['forgot-email'];
                    $data['resetCode'] = $_POST['reset-code-text'];
                    $data['no-new-password'] = 'Please enter a password';
                }else if(empty($_POST['confirm-password'])){
                    $data['mail'] = $_POST['forgot-email'];
                    $data['resetCode'] = $_POST['reset-code-text'];
                    $data['no-confirm-password'] = 'Please confirm your password';
                }
            }
        }else if(isset($_POST['authenticated'])){
            $data['auth-status'] = true;
            if(!empty($_POST['forgot-email']) && !empty($_POST['reset-code-text'])){
                $model = $this->model('LoginModel');
                $userCreds = $model->getPasswordResetCredentials($_POST['forgot-email']);
                if ($userCreds && (!$userCreds['error'] && !$userCreds['nodata'])) {
                    if($_POST['forgot-email'] == $userCreds['result'][0]['email']){
                        $data['mail'] = $userCreds['result'][0]['email'];
                        $resetCode = $userCreds['result'][0]['password_reset_code'];
                        $resetTime = $userCreds['result'][0]['reset_code_time'];
                        date_default_timezone_set('Asia/Colombo');
                        $currentTime = date('Y-m-d H:i:s');
                        if($resetCode == $_POST['reset-code-text'] && $resetTime > $currentTime){
                            $data['resetCode'] = $_POST['reset-code-text'];
                            $data['auth-status'] = true;
                        }else if($resetTime <= $currentTime){
                            $data['auth-status'] = false;
                            $data['reset-time-err'] = 'Reset code time has been expired!';
                            $data['mail-success'] = '';
                            $data['mail'] = '';
                            $data['resetCode'] = '';
                        }else{
                            $data['reset-code-unmatch'] = 'Invalid Reset Code';
                            $data['auth-status'] = false;
                        }
                    }else{
                        $data['reset-mail-unmatch'] = 'Invalid Email Address';
                    }
                }else if($userCreds['nodata']) {
                    $data['reset-code-err'] = 'Reset code not found!';
                    $data['mail-success'] = '';
                } else {
                    $data['reset-auth-err'] = 'Error occurred..! Please try again';
                }
            }else {
                if(empty($_POST['forgot-email'])){
                    $data['no-email'] = 'Please enter your email address';
                }
                if(empty($_POST['reset-code-text'])){
                    $data['no-code'] = 'Please enter the reset code';
                }
            }
        }else if(isset($_POST['enterCode'])){
            $data['auth-status'] = false;
            if(!empty($_POST['forgot-email']) && !empty($_POST['reset-code-text'])){
                $model = $this->model('LoginModel');
                $userCreds = $model->getPasswordResetCredentials($_POST['forgot-email']);
                if ($userCreds && (!$userCreds['error'] && !$userCreds['nodata'])) {
                    if($_POST['forgot-email'] == $userCreds['result'][0]['email']){
                        $data['mail'] = $userCreds['result'][0]['email'];
                        $resetCode = $userCreds['result'][0]['password_reset_code'];
                        $resetTime = $userCreds['result'][0]['reset_code_time'];
                        date_default_timezone_set('Asia/Colombo');
                        $currentTime = date('Y-m-d H:i:s');
                        if($resetCode == $_POST['reset-code-text'] && $resetTime > $currentTime){
                            $data['resetCode'] = $_POST['reset-code-text'];
                            $data['auth-status'] = true;
                        }else if($resetTime <= $currentTime){
                            $data['reset-time-err'] = 'Reset code time has been expired!';
                            $data['mail-success'] = '';
                            $data['mail'] = '';
                            $data['resetCode'] = '';
                        }else{
                            $data['reset-code-unmatch'] = 'Invalid Reset Code';
                            
                        }
                    }else{
                        $data['reset-mail-unmatch'] = 'Invalid Email Address';
                    }
                }else if($userCreds['nodata']) {
                    $data['reset-code-err'] = 'Reset code not found!';
                    $data['mail-success'] = '';
                } else {
                    $data['reset-auth-err'] = 'Error while authenticating..! Please try again';
                }
            }else{
                if(empty($_POST['forgot-email'])){
                    $data['no-email'] = 'Please enter your email address';
                }
                if(empty($_POST['reset-code-text'])){
                    $data['no-code'] = 'Please enter the reset code';
                }
            } 
        }else if(isset($_POST['resetCode'])){
            $data['no-email'] = '';
            $data['no-user'] = '';
            $data['reset-err'] = '';
            $data['mail-success'] = '';
            if(!empty($_POST['forgot-email'])){
                $model = $this->model('LoginModel');
                $userCreds = $model->getPasswordResetCredentials($_POST['forgot-email']);
                if ($userCreds && (!$userCreds['error'] && !$userCreds['nodata'])) {
                    if($userCreds['result'][0]['email']==$_POST['forgot-email']){
                        date_default_timezone_set('Asia/Colombo');
                        $data['mail'] = $userCreds['result'][0]['email'];
                        $currentResetCode = $userCreds['result'][0]['password_reset_code'];
                        $currentResetTime = $userCreds['result'][0]['reset_code_time'];
                        $now = date('Y-m-d H:i:s');
                        if(!empty($currentResetCode) && !empty($currentResetTime) && $currentResetTime >= $now){
                            $data['code-time-limit'] = 'You have already received a reset code.<br /> Please try again later';
                        }else{
                            $resetCode = rand(100000,999999);
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
                            
                            if($model->setResetCode($data['mail'], ['resetCode'=>$resetCode, 'resetTime'=>$resetTime])){
                                if(Email::send($data['mail'], 'Password Reset', $content)){
                                    $data['mail-success'] = 'Reset Code Sent to your Email';
                                    $data['codeTime'] = $resetTime;
                                    unset($_POST['resetCode']);
                                }else{
                                    $data['reset-err'] = Email::send($data['mail'], 'Password Reset', $content)['errmsg'];
                                }
                            }
                        }
                    }else{
                        $data['no-user'] = 'No User found with that email';
                    }
                }else if($userCreds['nodata']) {
                    $data['no-user'] = 'No User found with that email';
                } else {
                    $data['reset-err'] = 'Error while searching for user..! Please try again';
                }
            }else{
                $data['no-email'] = "Please enter your email";
                unset($_POST['resetCode']);
            }
        }
        $this->view('Login/passwordReset', 'Reset Password', $data, ['main', 'Components/form', 'login']);
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
        die();
    }
}
