<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaints</title>
    <link rel="stylesheet" href="<?php echo URLROOT . "/public/css/complaint.css" ?>">
</head>

<div class="logo">
    <img src="<?php echo URLROOT . "/public/assets/Logo.jpg" ?>" alt="" srcset="">
</div>
<div class="text-head">
    <h1>Chilaw</h1>
    <h3>Pradeshiya Sabha</h3>
</div>

<hr class="hr1">

<div class="navbar">
    <ul>
        <li>
            <a href="#">Services</a>
            <div class="dropdown-content">
                <ul>
                    <li><a href="#">A</a></li>
                    <li><a href="#">B</a></li>
                    <li><a href="#">C</a></li>
                </ul>
            </div>
        </li>

        <li>
            <a href="#">Projects</a>
        </li>

        <li>
            <a href="#">Events</a>
            <div class="dropdown-content">
                <ul>
                    <li><a href="#">A</a></li>
                    <li><a href="#">B</a></li>
                    <li><a href="#">C</a></li>
                </ul>
            </div>
        </li>


        <li>
            <a href="#">Announcements</a>
            <div class="dropdown-content">
                <ul>
                    <li><a href="#">A</a></li>
                    <li><a href="#">B</a></li>
                    <li><a href="#">C</a></li>
                </ul>
            </div>
        </li>


        <li>
            <a href="#">Contact Us</a>

        </li>
    </ul>
</div>
<hr class="hr1">
<div class="user">
    <p> <a href="#"> <?= $_SESSION['name'] ?> </a> </p>
    <img src="<?php echo URLROOT . "/public/assets/user.png" ?>" alt="" srcset="" class="user-logo">
</div>
<?php
require_once 'Logout.php';
?>