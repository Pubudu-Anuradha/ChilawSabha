<div class="navbar">
    <input type="checkbox" name="anonymous" id="hamburger-trigger"
        aria-label="open or close the hamburger menu">
    <div class="lines">
        <span class="line1"></span>
        <span class="line2"></span>
        <span class="line3"></span>
    </div>
    <div class="navbar-items">
        <ul>
            <li class="dropdown"><a href="<?= URLROOT . '/Home/'?>" class="dropbtn">Home</a></li>
            <li class="dropdown"><a href="<?= URLROOT . '/Posts/Announcements'?>" class="dropbtn">Announcements</a>
                <ul class="dropdown-content">
                    <?php
                    require_once 'app/models/AnnouncementModel.php';
                    $model = new AnnouncementModel;
                    $types = $model->getTypes();
                    if($types):
                        foreach($types as $type):
                            if($type['ann_type'] !== 'All'):
                                $type_id = $type['ann_type_id'];?>
                        <li onclick='window.location.href="<?=URLROOT . "/Posts/Announcements?category=$type_id"?>"'><?= $type['ann_type'] ?></li>
                    <?php endif; endforeach; endif; ?>
                </ul>
            </li>
            <li class="dropdown"><a href="<?= URLROOT . '/Posts/Projects' ?>" class="dropbtn">Projects</a>
                <?php require_once 'app/models/ProjectModel.php';
                    $model = new ProjectModel;
                    $status = $model->getStatus();
                    if($status):?>
                        <ul class="dropdown-content">
                            <?php foreach($status as $stat):?>
                                <li onclick='window.location.href="<?=URLROOT . "/Posts/Projects?status=$stat[status_id]"?>"'><?= $stat['project_status'] ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
            </li>
            <li class="dropdown"><a href="<?= URLROOT . '/Posts/Events' ?>" class="dropbtn">Events</a>
            </li>
            <li class="dropdown"><a href="<?= URLROOT . '/Posts/Services' ?>" class="dropbtn">Services</a>
                <?php require_once 'app/models/ServiceModel.php';
                $categories = (new ServiceModel)->getCategories(true);
                ?>
                <ul class="dropdown-content">
                <?php foreach($categories as $cat_id => $cat): ?>
                    <li onclick='window.location.href="<?=URLROOT . "/Posts/Services?category=$cat_id"?>"'><?= $cat ?></li>
                <?php endforeach; ?>
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
                @media screen and (max-width: 767px) {
                    .login-btn::before{
                        bottom: 0px;
                    }
                }
            </style>
        </ul>
    </div>
</div>