<?php require_once 'Header.php';?>

    <div style="display:flex">
        <?php require_once 'Dashboard.php'; ?>

        <div class="dashboardContainer">
            <h1 class="dashboardTitle">Welcome To Dashboard</h1>
            <form action="<?=URLROOT . '/Login/Logout'?>" method="post">
                <input type="submit" value="Logout" name = "logout" class="logout" />
            </form>
        </div>
    </div>
    

<?php require_once 'Footer.php';?>