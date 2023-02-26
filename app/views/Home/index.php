<div class="slideshow">
    <img src="" alt="slideshow" id="slideshow">
    <button  class="slideshow-btn left-btn" onclick='prev(["<?=URLROOT . "/public/assets/sabha1.jpg"?>","<?=URLROOT . "/public/assets/sabha2.jpg"?>"])'>&#10094;</button>
    <button  class="slideshow-btn right-btn" onclick='next(["<?=URLROOT . "/public/assets/sabha1.jpg"?>","<?=URLROOT . "/public/assets/sabha2.jpg"?>"])'>&#10095;</button>

</div>
<!-- <h2>Links</h2>
    <a href="<?=URLROOT . "/References/"?>"> References </a> <br> -->

<div class="page-content">
    <div class="left-content">
        <div class="emergency-numbers">
            <a href="<?=URLROOT . "/Home/emergency"?>"><h3>Emergency Contacts</h3></a>
            <div class="number">
                <a href="#" class="name">
                    Hospital/Ambulance hotline
                </a>
                <span class="tel">
                    0717777777
                </span>
            </div>
            <div class="number">
                <a href="#" class="name">
                    Fire Department
                </a>
                <span class="tel">
                    0717777777
                </span>
            </div>
            <div class="number">
                <a href="#" class="name">
                    Madampe Police station
                </a>
                <span class="tel">
                    0717777777
                </span>
            </div>
            <div class="number">
                <a href="#" class="name">
                   Other Emergency Contacts
                </a>
            </div>
        </div>
        <div class="section">
            <div class="library-portal">        
                <a class="library-img" href="<?=URLROOT . "/Home/Portal"?>">
                    <span>
                        Chilaw Public Library
                    </span>
                </a>
            </div>
            <div class="contact-us">
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
            background-position: center;
            background-repeat:no-repeat;
            background-size:contain;
        }
        .library-img{
            display:flex;
            align-items: center;
            justify-content: center;
            background: url("<?=URLROOT . '/public/assets/Library.jpeg'?>");
            background-position: center;
            background-repeat: space;
            background-size: contain;
            width: 100%;
            height: 17rem;
            color: #fff !important;
            font-weight: 800;
            font-size: large;
        }
    </style>
    <div class="main-content">
        <div class="posts bg-fd-blue">
            <div class="posts-header">
                <a href="#"><h2 class="announcement-txt">Announcements</h2></a>
                <button class="more btn bg-lightblue hover-bg-blue" onclick='window.location.href="<?=URLROOT . "/Posts/Announcements"?>"'>More</button>
            </div>
            <hr>
            <div class="post">
                <div class="sabha-img"></div>
                <div class="details">
                    <a class="title" href="#">REGISTER FOR COVID 19 VACCINATIONS</a>
                    <div class="date">
                        21 January 2023
                    </div>
                </div>
            </div>
            <div class="post">
                <div class="sabha-img"></div>
                <div class="details">
                    <a class="title" href="#">REGISTER FOR COVID 19 VACCINATIONS</a>
                    <div class="date">
                        21 January 2023
                    </div>
                </div>
            </div>
            <div class="post">
                <div class="sabha-img"></div>
                <div class="details">
                    <a class="title" href="#">REGISTER FOR COVID 19 VACCINATIONS</a>
                    <div class="date">
                        21 January 2023
                    </div>
                </div>
            </div>
        </div>

        <div class="posts bg-fd-blue">
            <div class="posts-header">
                <a href="#"><h2 class="announcement-txt">Events</h2></a>
                <button class="more btn bg-lightblue hover-bg-blue" onclick='window.location.href="<?=URLROOT . "/Posts/Events"?>"'>More</button>
            </div>
            <hr>
            <div class="post">
                <div class="sabha-img"></div>
                <div class="details">
                    <a class="title" href="#">REGISTER FOR COVID 19 VACCINATIONS</a>
                    <div class="date">
                        21 January 2023
                    </div>
                </div>
            </div>
        </div>
        <div class="posts bg-fd-blue">
            <div class="posts-header">
                <a href="#"><h2 class="announcement-txt">Services</h2></a>
                <button class="more btn bg-lightblue hover-bg-blue" onclick='window.location.href="<?=URLROOT . "/Posts/Events"?>"'>More</button>
            </div>
            <hr>
            <div class="post">
                <div class="sabha-img"></div>
                <div class="details">
                    <a class="title" href="#">REGISTER FOR COVID 19 VACCINATIONS</a>
                    <div class="date">
                        21 January 2023
                    </div>
                </div>
            </div>
        </div>

        <div class="posts bg-fd-blue">
            <div class="posts-header">
                <a href="#"><h2 class="announcement-txt">Projects</h2></a>
                <button class="more btn bg-lightblue hover-bg-blue" onclick='window.location.href="<?=URLROOT . "/Posts/Events"?>"'>More</button>
            </div>
            <hr>
            <div class="post">
                <div class="sabha-img"></div>
                <div class="details">
                    <a class="title" href="#">REGISTER FOR COVID 19 VACCINATIONS</a>
                    <div class="date">
                        21 January 2023
                    </div>
                </div>
            </div>
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
            <button class="more btn" onclick='window.location.href="<?=URLROOT . "/AboutCity"?>"'>See More</button>
        </div>
        <div class="ward-map">
            <h3 class="ward-map-txt">WARD MAP</h3>
            <img src="<?=URLROOT . "/public/assets/wardmap.png"?>" alt="" class="ward-map-img">
        </div>
    </div>

    <div class="right-content">
    </div>
</div>
    <!-- Function to load slideshow -->
    <script>

      let index = 0;

      function slideshow(images) {
          const image = document.getElementById("slideshow");
          image.src = images[index];
          setInterval( function() {
            index = (index + 1) % images.length;
            image.src = images[index];
          }, 4000);
      }

      function next(images){
        const image = document.getElementById("slideshow");
        index = (index + 1) % images.length;
        image.src = images[index];

      }

      function prev(images){
        const image = document.getElementById("slideshow");
        index =(images.length + (index - 1)) % images.length;
        image.src = images[index];
      }

      slideshow(["<?=URLROOT . "/public/assets/sabha1.jpg"?>","<?=URLROOT . "/public/assets/sabha2.jpg"?>"]);
    </script>