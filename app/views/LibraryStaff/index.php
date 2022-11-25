<?php require_once 'Header.php';?>

<div class="sidebar">
    <a href="<?=URLROOT . "/LibraryStaff/index"?>" class="option">LEND/RECIEVE BOOKS</a>
    <a href="<?=URLROOT . "/LibraryStaff/viewbooks"?> " class="option">BOOK CATALOGUE</a>
    <a href="#" class="option">USER MANAGEMENT</a>
    <a href="#" class="option">ANALYTICS</a>
    <a href="#" class="option">LOST BOOKS</a>
    <a href="#" class="option">DE-LISTED BOOKS</a>
    <a href="#" class="option">BOOK REQUESTS</a>
</div>

<div class="content">
    <h1 class="dashboard">Welcome To Dasboard</h1>
    <form action="<?=URLROOT . '/Login/Logout'?>" method="post">
        <input type="submit" value="Logout" name = "logout" class="btn-logout" />
    </form>
    <hr class="h-ruler" />
</div>

<?php require_once 'Footer.php';?>