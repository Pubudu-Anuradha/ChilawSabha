<?php require_once 'Header.php';?>

<div class="sidebar">
    <a href="#" class="option">DASHBOARD</a>
    <a href="#" class="option">BOOK CATALOGUE</a>
    <a href="#" class="option">FAVOURITE LIST</a>
    <a href="#" class="option">PLAN TO READ LIST</a>
    <a href="#" class="option">COMPLETED LIST</a>
    <a href="#" class="option">BOOK REQUESTS</a>
</div>

<div class="content">
    <h1 class="dashboard">WELCOME TO CHILAW PUBLIC LIBRARY</h1>
    <form action="<?=URLROOT . '/Login/Logout'?>" method="post">
        <input type="submit" value="Logout" name = "logout" class="btn-logout" />
    </form>
    <hr class="h-ruler" />
</div>

<?php require_once 'Footer.php';?>