<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT . "/public/css/pubudu.css" ?>">
    <title>Chilaw Pradeshiya Sabha Demo</title>
</head>

<body>
    <div class="header">
        <div class="logos">
            <img class="logo" width="75" height="80px" src="<?= URLROOT . '/public/assets/Logo.jpg' ?>" alt="Sabha_Logo">
            <div class="sabhaname">
                <div class="chilaw">
                    CHILAW
                </div>
                <div class="sabha">
                    PRADESHIYA SABHA
                </div>
            </div>
        </div>
        <div class="drops">
            <div class="drop">Services</div>
            <div class="drop">Projects</div>
            <div class="drop">Events</div>
            <div class="drop">Announcements</div>
            <div class="drop">Contact Us</div>
        </div>
    </div>
    <div class="main">
        <div class="login">
            <div class="items">
                <div class="title">
                    <img src="<?= URLROOT . '/public/assets/Login.png' ?>" height="60px" alt="Login img"> <br />
                    Admin Login
                </div>
                <form action="<?= URLROOT . "/Login/Admin" ?>" method="post">
                    <?php if (isset($data['message']) && $data['message'] == 'nouser') {
                        echo '<div class="log-err"> No User with that email exists </div>';
                    } ?>

                    <div class="field">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email"> <br>
                    </div>
                    <?php if (isset($data['message']) && $data['message'] == 'wrongpass') {
                        echo '<div class="log-err"> Wrong Password </div>';
                    } ?>
                    <div class="field">
                        <label for="passwd">Password</label>
                        <input type="password" name="passwd" id="passwd"> <br>
                    </div>
                    <a href="#">Forgot your password?</a>
                    <input type="submit" name="login" value="Login">
                </form>
            </div>
        </div>
    </div>
    <div class="footer">
        Copyright &#169; 2022
    </div>
</body>

</html>