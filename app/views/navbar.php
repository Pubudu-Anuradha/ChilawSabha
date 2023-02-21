<div class="navbar">
    <div class="navbar-items">
        <ul>
            <li class="dropdown"><a href="<?= URLROOT . '/Home/'?>" class="dropbtn">Home</a></li>
            <li class="dropdown"><a href="<?= URLROOT . '/Posts/Announcements'?>" class="dropbtn">Announcements</a>
                <ul class="dropdown-content">
                    <?php foreach(['Financial','Government','Tender'] as $category):?>
                        <li onclick='window.location.href="<?=URLROOT . "/Posts/Announcements?category=$category"?>"'><?= $category ?></li>
                    <?php endforeach; ?>
                </ul>
            </li>
            <li class="dropdown"><a href="#" class="dropbtn">Events</a>
                <ul class="dropdown-content">
                    <li>Christmas Celebration</li>
                    <li>New Year Celebration</li>
                    <li>Deepavali Celebration</li>
                </ul>
            </li>
            <li class="dropdown"><a href="#" class="dropbtn">Projects</a>
                <ul class="dropdown-content">
                    <li>UNICEF Project</li>
                    <li>Worldbank Project</li>
                    <li>Water Waste Management Project</li>
                </ul>
            </li>
            <li class="dropdown"><a href="#" class="dropbtn">Services</a>
                <ul class="dropdown-content">
                    <li>Health</li>
                    <li>Playgrounds</li>
                    <li>Kindergardens</li>
                </ul>
            </li>
            <li class="dropdown"><a href="<?=URLROOT . "/Home/downloads"?>" class="dropbtn">Downloads</a></li>
            <li class="dropdown"><a href="<?= URLROOT . '/ContactUs/'?>" class="dropbtn">Contact Us</a></li>
        </ul>
        <ul class="login-list">
            <li>
            <?php if(isset($_SESSION['login'])):?>
                <li class="dropdown login-btn"><a href="#" class="dropbtn"><?= $_SESSION['name']?></a>
                    <ul class="dropdown-content">
                            <li> <a href="<?= URLROOT.'/'.$_SESSION['role']?>">Dashboard</a></li>
                            <li> <a href="<?= URLROOT.'/Login/Logout'?>">Logout</a></li>
                    </ul>
                </li>
            <?php else: ?>
                <li class="dropdown login-btn"><a href="<?= URLROOT.'/Login'?>" class="dropbtn">Login</a>
            <?php endif; ?>
            </li>
            <style>
                .login-btn{
                    position: relative;
                }
                .login-btn::before{
                    position: absolute;
                    content: " ";
                    width: 40px;
                    height: 40px;
                    background: url("<?=URLROOT . '/public/assets/user.png'?>");
                    background-repeat: none;
                    background-size: contain;
                    bottom: 7.5px;
                    left: -45px;
                }
            </style>
        </ul>
    </div>
</div>