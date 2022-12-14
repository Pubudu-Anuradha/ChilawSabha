<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Storage Manager</title>
    <link rel="stylesheet" href="<?php echo URLROOT . "/public/css/storage.css" ?>" />
</head>

<body>
    <div class="upperHeader">
        <img src="<?= URLROOT . "/public/assets/Logo.jpg" ?>" alt="Chilaw Pradeshiya Sabha Logo" class="logo" />
        <div class="titleContainer">
            <div class="upperTitle">
                CHILAW
            </div>
            <div class="lowerTitle">
                PRADESHIYA SABHA
            </div>
        </div>
    </div>

    <div class="lowerHeader">
        <div class="navItem">
            <a href="#" class="nav">Services</a>
        </div>
        <div class="navItem">
            <a href="#" class="nav">Projects</a>
        </div>
        <div class="navItem">
            <a href="#" class="nav">Events</a>
        </div>
        <div class="navItem">
            <a href="#" class="nav">Announcements</a>
        </div>
        <div class="navItem">
            <a href="#" class="nav">Contact Us</a>
        </div>
    </div>


    <div class="loginContainer">
        <img src="<?= URLROOT . "/public/assets/Login.png" ?>" alt="Login Avatar" class="loginAvatar" />
        <h1 class="loginTitle">Storage Manager Login</h1>
        <div class="loginForm">
            <form action="<?= URLROOT . "/Login/Storage" ?>" method="post" class="form">
                <label for="email">Email</label>
                <input type="email" name="email" required class="email" /><br />
                
                <label for="password">Password</label>
                <input type="password" name="password" required class="password" /><br />
                
                <a href="#" class="forgot">Forgot your password?</a>

                <input type="submit" value="login" name="login" id="loginButton" />

            </form>
        </div>
    </div>


    <div class="footer">
        Copyright © 2022
    </div>


</body>

</html>