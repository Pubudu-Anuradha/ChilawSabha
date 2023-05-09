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
<?php Slideshow::Slideshow([URLROOT . "/public/assets/sabha1.jpg", URLROOT . "/public/assets/sabha2.jpg"]);?>
<!-- <h2>Links</h2>
    <a href="<?=URLROOT . "/References/"?>"> References </a> <br> -->
<div class="page-content">
    <div class="left-content">
        <div class="contacts">
            <a href="<?=URLROOT . "/Emergency"?>" class="title"><h3>Having An Emergency in the area? Click here for Important contacts that may be useful</h3></a>
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
                <a class="row" href="<?= URLROOT . '/ContactUs' ?>">
                    <h3>Contact us</h3>
                    <button class="btn bg-blue" type="button">See More</button>
                </a>
                <div class="contact">
                    <a href="#" class="name tel">
                        Telephone
                    </a>
                    <span class="contact-info">
                        032 - 2247675
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
            border-radius: 2rem;
            padding: 1rem;
            background: url("<?=URLROOT . '/public/assets/Library.jpeg'?>");
        }
        .library-img,.sabha-img{
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
    <div class="main-content">
<?php
[$announcements, $services, $projects, $events] = $data['posts'] ?? [[], [], [], []];
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
            <?php if(empty($announcements)):?>
                <div class="post shadow">
                    <div class="details">
                        <div class="title-row">
                            <a class="title" href="#">No Announcements</a>
                        </div>
                        <div class="summary">
                            There are no announcements at the moment.
                        </div>
                    </div>
                </div>
            <?php endif;?>
            <?php foreach ($announcements as $ann): ?>
                <div class="post shadow">
                    <div class="details">
                        <div class="title-row">
                            <a class="title"
                            href="<?=URLROOT . '/Posts/Announcement/' . ($ann['post_id'] ?? '0')?>"
                            > <?php if ($ann['pinned'] == 1): ?>
                                <span class="pinned">&#128204;</span>
                            <?php endif;?>
                            <?=$ann['title'] ?? 'Not Found'?> </a>
                            <a class="category"
                            href="<?=URLROOT . '/Posts/Announcements?category=' . ($ann['t_id'] ?? '0')?>"
                            > <?=$ann['ann_type'] ?? 'Not Found'?>
                        </a>
                        </div>
                        <div class="summary">
                            <?=$ann['short_description'] ?? 'Not Found'?>
                        </div>
                        <div class="date">
                            <?=$formatter->format(IntlCalendar::fromDateTime($ann['posted_time'] ?? '2022-01-01', null))?>
                        </div>
                    </div>
                </div>
            <?php endforeach?>
        </div>

        <div class="posts bg-fd-blue">
            <div class="posts-header">
                <a href="#"><h2 class="announcement-txt">Events</h2></a>
                <button class="more btn bg-lightblue hover-bg-blue" onclick='window.location.href="<?=URLROOT . "/Posts/Events"?>"'>More</button>
            </div>
            <hr>
            <?php if(empty($events)):?>
                <div class="post shadow">
                    <div class="details">
                        <div class="title-row">
                            <a class="title" href="#">No Events</a>
                        </div>
                        <div class="summary">
                            There are no events at the moment.
                        </div>
                    </div>
                </div>
            <?php endif;?>
            <?php foreach($events as $event):?>
                <div class="post shadow">
                    <div class="details">
                        <div class="title-row">
                            <a href="<?= URLROOT . '/Posts/Event/' . ($event['post_id'] ?? '0')?>" class="title"><?php if ($event['pinned'] == 1): ?>
                                <span class="pinned">&#128204;</span>
                            <?php endif;?>
                            <?=$event['title'] ?? 'Not Found'?> 
                        </a>
                        </div>
                        <div class="summary">
                            <?=$event['short_description'] ?? 'Not Found'?>
                        </div>
                        <div class="row">
<?php
$start_time = $event['start_time'] ? $formatter->format(
    IntlCalendar::fromDateTime($event['start_time'], null),
) : 'TBA';
$end_time = $event['end_time'] ? $formatter->format(
    IntlCalendar::fromDateTime($event['end_time'], null),
) : 'TBA';
?>
                            <div class="date">
                                Starting at : <?= $start_time ?>
                            </div>
                            <?php if($end_time != 'TBA'): ?>
                            <div class="date">
                                Ending at : <?= $end_time ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="posts bg-fd-blue">
            <div class="posts-header">
                <a href="#"><h2 class="announcement-txt">Services</h2></a>
                <button class="more btn bg-lightblue hover-bg-blue" onclick='window.location.href="<?=URLROOT . "/Posts/Events"?>"'>More</button>
            </div>
            <hr>
            <?php if(empty($services)):?>
                <div class="post shadow">
                    <div class="details">
                        <div class="title-row">
                            <a class="title" href="#">No Services</a>
                        </div>
                        <div class="summary">
                            There are no services at the moment.
                        </div>
                    </div>
                </div>
            <?php endif;?>
            <?php foreach($services as $service):?>
                <div class="post shadow">
                    <div class="details">
                        <div class="title-row">
                            <a href="<?= URLROOT . '/Posts/Service/' . ($service['post_id'] ?? '0')?>" class="title"><?php if ($service['pinned'] == 1): ?>
                                <span class="pinned">&#128204;</span>
                            <?php endif;?>
                            <?=$service['title'] ?? 'Not Found'?> </a>
                            <a class="category"
                            href="<?=URLROOT . '/Posts/Services?category=' . ($service['category_id'] ?? '0')?>"
                            > <?=$service['service_category'] ?? 'Not Found'?>
                        </a>
                        </div>
                        <div class="summary">
                            <?=$service['short_description'] ?? 'Not Found'?>
                        </div>
                        <div class="row">
                            <?php if($service['contact_no'] ?? false):?>
                            <div class="contact">
                                For more Information, call : <?= $service['contact_no'] ?>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="date">
                            <?=$formatter->format(IntlCalendar::fromDateTime($service['posted_time'] ?? '2022-01-01', null))?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="posts bg-fd-blue">
            <div class="posts-header">
                <a href="<?=URLROOT . "/Posts/Projects"?>"><h2 class="announcement-txt">Projects</h2></a>
                <button class="more btn bg-lightblue hover-bg-blue" onclick='window.location.href="<?=URLROOT . "/Posts/Projects"?>"'>More</button>
            </div>
            <hr>
            <?php if(empty($projects)):?>
                <div class="post shadow">
                    <div class="details">
                        <div class="title-row">
                            <a class="title" href="#">No Projects</a>
                        </div>
                        <div class="summary">
                            There are no projects at the moment.
                        </div>
                    </div>
                </div>
            <?php endif;?>
            <?php foreach ($projects as $project): ?>
                <div class="post shadow">
                    <div class="details">
                        <div class="title-row">
                            <a href="<?=URLROOT . '/Posts/Project/' . ($project['post_id'] ?? '0')?>" class="title">
                                <?php if ($project['pinned'] == 1): ?>
                        <span class="pinned">&#128204;</span>
                    <?php endif;?>
                    <?=$project['title'] ?? 'Not Found'?>
                            </a>
<a class="status <?=$project['status'] ?? 'err'?>"
                        href="<?=URLROOT . '/Posts/Projects?status=' . ($project['status_id'] ?? '0')?>"
                        > <?=$project['status'] ?? 'Not Found'?>
                    </a>
                        </div>
                        <div class="summary">
                            <?=$project['short_description'] ?? 'Not Found'?>
                        </div>
                    </div>
                    <div class="row">
                        <?php
$date_formatter = new IntlDateFormatter(
    'en_US',
    IntlDateFormatter::LONG,
    IntlDateFormatter::NONE,
);
$start_date = $project['start_date'] ? $date_formatter->format(
    IntlCalendar::fromDateTime($project['start_date'], null),
) : 'TBA';
$expected_end_date = $project['expected_end_date'] ? $date_formatter->format(
    IntlCalendar::fromDateTime($project['expected_end_date'], null),
) : 'TBA';
?>
                        <div class="date">
                            Starting date : <?=$start_date?>
                        </div>
                        <div class="date">
                            Expected end date : <?=$expected_end_date?>
                        </div>
                        <?php $budget = $project['budget'] ?
'<span class="money">' . number_format($project['budget'], 2) . '</span>' : 'TBA'?>
                        <div class="budget">
                            Budget : <?=$budget?>
                        </div>
                    </div>
                </div>
            <?php endforeach;?>
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
<?php ViewCounter::count('Home Page'); ?>