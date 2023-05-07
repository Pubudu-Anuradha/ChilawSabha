<!-- Someone Style this -->
<h1>
    Welcome to the official website of the Chilaw Pradeshiya Sabha!
</h1>
<p>
    We are proud to serve the people of Chilaw and provide them with essential services and
    facilities. On this website, you can find information about announcements, projects, events,
    services, make complaints, access web services for the public library and more. We hope this
    website will help you connect with us and improve your quality of life in Chilaw. Thank you for
    visiting and please feel free to contact us if you have any questions or suggestions.
</p>
<!-- add some additional navigation shortcuts here -->
<?php Slideshow::Slideshow([URLROOT . "/public/assets/sabha1.jpg",URLROOT . "/public/assets/sabha2.jpg"]);?>
<!-- <h2>Links</h2>
    <a href="<?=URLROOT . "/References/"?>"> References </a> <br> -->
<div class="page-content">
    <div class="left-content">
        <div class="contacts">
            <a href="<?=URLROOT . "/Home/emergency"?>" class="title"><h3>Emergency Contacts</h3></a>
            <div class="contact">
                <a href="#" class="name tel">
                    Hospital/Ambulance hotline
                </a>
                <span class="contact-info">
                    0717777777
                </span>
            </div>
            <div class="contact">
                <a href="#" class="name tel">
                    Fire Department
                </a>
                <span class="contact-info">
                    0717777777
                </span>
            </div>
            <div class="contact">
                <a href="#" class="name tel">
                    Madampe Police station
                </a>
                <span class="contact-info">
                    0717777777
                </span>
            </div>
            <div class="contact">
                <a href="#" class="name">
                   Other Emergency Contacts
                </a>
            </div>
        </div>
        <div class="section">
            <div class="library-portal">        
                <a class="library-img" href="<?=URLROOT . "/Home/Portal"?>">
                    <span>
                        Chilaw Public Library Portal
                    </span>
                </a>
            </div>
            <div class="contacts">
                <a href="#">
                    <h3>Contact us</h3>
                </a>
                <div class="contact">
                    <a href="#" class="name tel">
                        Telephone
                    </a>
                    <span class="contact-info">
                        032 - 5656565
                    </span>
                </div>
                <div class="contact">
                    <a href="#" class="name email">
                        Email
                    </a>
                    <div class="contact-info">
                        <a href="mailto:chlawpsproject@gmail.com">chlawpsproject@gmail.com</a>
                    </div>
                </div>
                <div class="contact">
                    <a href="#" class="name address">
                        Address
                    </a>
                    <div class="contact-info">
                        Chilaw Pradeshiya Sabha, <br> Kuliyapitya Road, <br> Madampe
                    </div>
                </div>
                <button class="add-complaint btn bg-lightblue hover-bg-blue"
                        onclick='window.location.href="<?=URLROOT . "/Home/Addcomplaint"?>"'>
                        MAKE A COMPLAINT
                </button>
            </div>
        </div>
    </div>
    <style>
        .sabha-img{
            background: url("<?=URLROOT . '/public/assets/logo.jpg'?>");
        }
        .library-img{
            background: url("<?=URLROOT . '/public/assets/Library.jpeg'?>");
        }
        .library-img,.sabha-img{
            background-position: center;
            background-repeat: no-repeat;
            background-size: contain;
        }
    </style>
    <div class="main-content">
<?php
    [$announcements,$services,$projects,$events] = $data['posts'] ?? [[],[],[],[]];
    $formatter = new IntlDateFormatter(
        'en_US',
        IntlDateFormatter::LONG,
        IntlDateFormatter::SHORT,
    );
?>
        <div class="posts bg-fd-blue">
            <div class="posts-header">
                <a href="#"><h2 class="announcement-txt">Announcements</h2></a>
                <button class="more btn bg-lightblue hover-bg-blue" onclick='window.location.href="<?=URLROOT . "/Posts/Announcements"?>"'>More</button>
            </div>
            <hr>
            <?php foreach($announcements as $ann): ?>
                <div class="post">
                    <div class="sabha-img" onclick="window.location.href = '<?= URLROOT . 
                    '/Posts/Announcement/' . ($ann['post_id'] ?? '0') ?>'"></div>
                    <div class="details">
                        <div class="title-row">
                            <a class="title"
                            href="<?= URLROOT . '/Posts/Announcement/' . ($ann['post_id'] ?? '0')?>"
                            > <?php if($ann['pinned']==1):?>
                                <span class="pinned">&#128204;</span>
                            <?php endif; ?>
                            <?= $ann['title'] ?? 'Not Found' ?>
                            <a class="category"
                            href="<?= URLROOT . '/Posts/Announcements?category=' . ($ann['t_id'] ?? '0')?>"
                            > <?= $ann['ann_type'] ?? 'Not Found' ?>
                        </a>
                        </div>
                        <div class="summary">
                            <?= $ann['short_description'] ?? 'Not Found' ?>
                        </div>
                        <div class="date">
                            <?= $formatter->format(IntlCalendar::fromDateTime($ann['posted_time'] ?? '2022-01-01',null)) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>

        <div class="posts bg-fd-blue">
            <div class="posts-header">
                <a href="#"><h2 class="announcement-txt">Events</h2></a>
                <button class="more btn bg-lightblue hover-bg-blue" onclick='window.location.href="<?=URLROOT . "/Posts/Events"?>"'>More</button>
            </div>
            <hr>
            <!-- TODO: GET FROM MODEL -->
        </div>
        <div class="posts bg-fd-blue">
            <div class="posts-header">
                <a href="#"><h2 class="announcement-txt">Services</h2></a>
                <button class="more btn bg-lightblue hover-bg-blue" onclick='window.location.href="<?=URLROOT . "/Posts/Events"?>"'>More</button>
            </div>
            <hr>
            <!-- TODO: GET FROM MODEL -->
        </div>

        <div class="posts bg-fd-blue">
            <div class="posts-header">
                <a href="#"><h2 class="announcement-txt">Projects</h2></a>
                <button class="more btn bg-lightblue hover-bg-blue" onclick='window.location.href="<?=URLROOT . "/Posts/Events"?>"'>More</button>
            </div>
            <hr>
            <!-- TODO: GET FROM MODEL -->
        </div>

        <div class="about-city">
            <h2>About Chilaw</h2>
            <hr>
            <p class="about-para">
                Chilaw is located approximately 65km from the Bandaranaike International Airport, 
                making it a great stop-over whether you’re just arriving or leaving the island. 
                The coastal town is known for its culturally diverse background where you can visit 
                religious shrines and for its natural treasures, where you can embark on a bird-watching
                excursion through the Muthurajawela Wetlands. Chilaw offers many things to do and places 
                to visit if you’re spending your holiday here. 
            </p>
            <button class="more btn bg-blue" onclick='window.location.href="<?=URLROOT . "/AboutCity"?>"'>See More</button>
        </div>
        <div class="ward-map">
            <h3 class="ward-map-txt">WARD MAP</h3>
            <img src="<?=URLROOT . "/public/assets/wardmap.png"?>" alt="" class="ward-map-img">
        </div>
    </div>

    <div class="right-content">
    </div>
</div>
