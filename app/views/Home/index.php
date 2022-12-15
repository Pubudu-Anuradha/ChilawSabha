<?php require_once 'Header.php'; ?>
<div class="home">
    <h1>
        Welcome to the demo Home page
    </h1>

    <a class="admin" href="<?= URLROOT . "/Login/Admin" ?>">Admin Demo Login</a>
    <a class="libread" href="<?= URLROOT . "/Login/LibraryMember" ?>">Library Member Demo Login</a>
    <a class="libstaff" href="<?= URLROOT . "/Login/LibraryStaff" ?>">Library Staff Demo Login</a>
    <a class="complaint" href="<?= URLROOT . "/Login/Complaint" ?>">Complaint Handler Demo Login</a>
    <a class="storage" href="<?= URLROOT . "/Login/Storage" ?>">Storage Manager Demo Login</a>

    <?php require_once 'Footer.php'; ?>
</div>