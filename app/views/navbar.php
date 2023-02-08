<div class="navbar">
    <div class="navbar-items">
        <ul>
            <li class="dropdown"><a href="<?= URLROOT . '/Home/'?>" class="dropbtn">Home</a></li>
            <li class="dropdown"><a href="#" class="dropbtn">Announcements</a>
                <ul class="dropdown-content">
                    <li>Announcement 1</li>
                    <li>Announcement 2</li>
                    <li>Announcement 3</li>
                </ul>
            </li>
            <li class="dropdown"><a href="#" class="dropbtn">Downloads</a>
                <ul class="dropdown-content">
                    <li>Download 1</li>
                    <li>Download 2</li>
                    <li>Download 3</li>
                </ul>
            </li>
            <li class="dropdown"><a href="#" class="dropbtn">Events</a>
                <ul class="dropdown-content">
                    <li>Event 1</li>
                    <li>Event 2</li>
                    <li>Event 3</li>
                </ul>
            </li>
            <li class="dropdown"><a href="#" class="dropbtn">Projects</a>
                <ul class="dropdown-content">
                    <li>Project 1</li>
                    <li>Project 2</li>
                    <li>Project 3</li>
                </ul>
            </li>
            <li class="dropdown"><a href="#" class="dropbtn">Services</a>
                <ul class="dropdown-content">
                    <li>Service 1</li>
                    <li>Service 2</li>
                    <li>Service 3</li>
                </ul>
            </li>
        </ul>
        <ul class="login-list">
            <li>
            <?php if(isset($_SESSION['login'])):?>
                <li class="dropdown login-btn"><a href="#" class="dropbtn">Login</a>
                    <ul class="dropdown-content">
                            <li> <a href="<?= URLROOT.'/'.$_SESSION['role']?>">Dash Board</a></li>
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