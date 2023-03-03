<?php

class Login extends Controller
{
    use Email;
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
        $this->view('Login/index', 'Login', $data,['login']);
    }

    public function passwordReset()
    {
        $data = [];
        if(isset($_POST['Submit'])){

        }elseif(isset($_POST['resetCode'])){
            if(isset($_POST['forgot-email'])){
                $model = $this->model('LoginModel');
                $userCreds = $model->getUserCredentials($_POST['forgot-email']);

                if ($userCreds && (!$userCreds['error'] && !$userCreds['nodata'])) {
                    $resetCode = rand(100000,999999);
                    $resetTimeFormat = mktime(
                        date('H'), date('i')+5, date('s'), date('m'), date('d'), date('Y')
                    );
                    $resetTime = date('Y-m-d H:i:s', $resetTimeFormat);

                    $content = "
                        <!DOCTYPE html>
                        <html lang='en'>
                        
                        <head>
                            <meta charset='UTF-8' />
                            <meta http-equiv='X-UA-Compatible' content='IE=edge' />
                            <meta name='viewport' content='width=device-width, initial-scale=1.0' />
                            <title>Password Reset</title>
                            <?php foreach (\$styles as \$style) { ?>
                                <link rel='stylesheet' href=\"<?= URLROOT . '/public/css/' . \$style ?>.css\">
                            <?php } ?>
                            <style>
                                * {
                                    margin: 0;
                                    padding: 0;
                                    box-sizing: border-box;
                                }
                                body{
                                    background-color: var(--bgcolor);
                                }
                                .reset-content-div {
                                    margin: 5rem auto;
                                    padding: 2rem 2rem;
                                    width: 40rem;
                                    justify-content: center;
                                    align-items: center;
                                    border: 1px solid var(--lightblue);
                                    background-color: var(--fadedblue);
                                    border-radius: 1rem;
                                }
                                .reset-content-div h1{
                                    font-size: 2rem;
                                    font-weight: 700;
                                    color: #000000;
                                    margin-bottom: 2rem;
                                }
                                .reset-code{
                                    justify-content: center;
                                    align-items: center;
                                    box-sizing: border-box;
                                    text-align: center;
                                    width: fit-content;
                                    padding: 1rem 2rem;
                                    border-radius: 1rem;
                                    background-color: var(--lightblue);
                                    margin: 1rem 3rem;
                                    color: var(--white);
                                }
                                p{
                                    font-size: 1.2rem;
                                    font-weight: 500;
                                    color: #000000;
                                }
                                @media screen and (max-width: 768px) {
                                    .reset-content-div {
                                        width: 80%;
                                        padding: 1rem 1rem;
                                    }
                                    .reset-content-div h1{
                                        font-size: 1.5rem;
                                        margin-bottom: 1rem;
                                    }
                                    .reset-code{
                                        margin: 1rem 1rem;
                                    }
                                    p{
                                        font-size: 1rem;
                                    }
                                }
                            </style>
                        </head>
                        
                        <body>
                            <div class='logo-area'>
                                <div class='logo-items' onclick='window.location.href= \"<?=URLROOT . '/Home'?>\"'>
                                    <div class='logo'>
                                        <img src=\"<?= URLROOT . '/public/assets/logo.jpg' ?>\" height='100' width='90' alt='Sabha Logo'>
                                    </div>
                                    <div class='sabha-title'>
                                        <img src=\"<?= URLROOT . '/public/assets/logo_text.png' ?>\" height='100' alt='Chilaw Pradeshiya Sabha'>
                                    </div>
                                </div>
                            </div>
                            <div class='reset-content-div'>
                                <h1>User Password Reset</h1>
                                <p>
                                    Use following code to reset your password:
                                </p>
                        
                                <div class='reset-code'>
                                    <h2>$resetCode</h2>
                                </div>
                                
                                <p>If you don't use this code within 5 minutes, it will expire.<br/> 
                                To get a new password reset link, 
                                    <a href='<?= URLROOT . ?>/Login/passwordReset'>
                                        Click Here!
                                    </a><br/>
                                </p>&nbsp;<br/>
                        
                                <p>Thanks,<br/>
                                Chilaw Pradeshiya Sabha </p>
                            </div>
                        </body>
                        </html>
                    ";
                    $this->send($_POST['forgot-email'], 'Password Reset', $content);
                    $model->setResetCode($userCreds['result'][0], [$resetCode, $resetTime]);
                    
                }else if($userCreds['nodata']) {
                    $data['nouser'] = 'No User found with that email';
                } else {
                    $data['reseterr'] = 'Error while searching for user..! Please try again';
                }
            }
        }
        $this->view('Login/passwordReset', 'Reset Password', [], ['main', 'Components/form', 'login']);
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
