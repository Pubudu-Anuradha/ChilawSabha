<?php require_once 'Header.php';?>

    <div style="display:flex">
        <div class="dashboard">
            <a href="<?= URLROOT . "/Storage/index" ?>" class="option">Dashboard</a>
            <a href="<?= URLROOT . "/Storage/ViewItems" ?>" class="option">View Items</a>
            <a href="<?= URLROOT . "/Storage/AddNewItemType" ?>" class="option">Add New Type of Item</a>
            <a href="#" class="option">Issue Items</a>
            <a href="#" class="option">Recieve Items</a>
            <a href="#" class="option">Damaged Items</a>
            <a href="#" class="option">Nearly Out of Stock Items</a>
            <a href="#" class="option">Issue And Recieve History</a>
        </div>

        <div class="dashboardContainer">
            <h1 class="dashboardTitle">Welcome To Dashboard</h1>
            <form action="<?=URLROOT . '/Login/Logout'?>" method="post">
                <input type="submit" value="Logout" name = "logout" class="logout" />
            </form>
        </div>
    </div>
    

<?php require_once 'Footer.php';?>