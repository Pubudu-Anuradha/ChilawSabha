<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="<?php echo URLROOT . "/public/css/complaint.css" ?>">




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
                <a href="#" class="dropbtn">Services</a>
                <div class="dropdown-content">
                    <ul>
                        <li><a href="#">A</a></li>
                        <li><a href="#">B</a></li>
                        <li><a href="#">C</a></li>
                    </ul>
                </div>
            </li>

            <li>
                <a href="#" class="dropbtn">Projects</a>
            </li>

            <li>
                <a href="#" class="dropbtn">Events</a>
                <div class="dropdown-content">
                    <ul>
                        <li><a href="#">A</a></li>
                        <li><a href="#">B</a></li>
                        <li><a href="#">C</a></li>
                    </ul>
                </div>
            </li>


            <li>
                <a href="#" class="dropbtn">Announcements</a>
                <div class="dropdown-content">
                    <ul>
                        <li><a href="#">A</a></li>
                        <li><a href="#">B</a></li>
                        <li><a href="#">C</a></li>
                    </ul>
                </div>
            </li>


            <li>
                <a href="#" class="dropbtn">Contact Us</a>

            </li>
        </ul>
    </div>
    <hr class="hr1">

</head>









<body>
    <div class="login-form">
        <h1>Complaint Handler Login</h1>
        <form action="<?= URLROOT . "/Login/Complaint" ?>" method="post">

            <?php if (isset($data['message'])) {
                echo $data['message'];
            } ?>

            <p>Email</p>
            <input type="email" id="email" class="form-control" name="email" />



            <p>Password</p>
            <input type="password" id="password" class="form-control" name="password" />

            <input type="submit" class="btn-primary" value="Login" name="login">
            <a href="#" class="forgot">Forgot your password?</a>
        </form>

    </div>

</body>




<!-- <?php require_once 'Logout.php'; ?> -->


<Footer>
    <div class="copyright">
        Copyright @2022
    </div>
</Footer>

</html>