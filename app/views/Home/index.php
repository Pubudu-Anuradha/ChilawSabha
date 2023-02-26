<div class="slideshow">

    <img src="" alt="slideshow" id="slideshow">

    <button  class="slideshow-btn left-btn" onclick='prev(["<?=URLROOT . "/public/assets/sabha1.jpg"?>","<?=URLROOT . "/public/assets/sabha2.jpg"?>"])'>&#10094;</button>
    <button  class="slideshow-btn right-btn" onclick='next(["<?=URLROOT . "/public/assets/sabha1.jpg"?>","<?=URLROOT . "/public/assets/sabha2.jpg"?>"])'>&#10095;</button>

</div>
<!-- <h2>Links</h2>
    <a href="<?=URLROOT . "/References/"?>"> References </a> <br> -->

<div class="page-content">
    <div class="left-content">
        <div>
            <button class="add-complaint btn"  onclick='window.location.href="<?=URLROOT . "/Home/Addcomplaint"?>"'> ADD A COMPLAINT </button>    
        </div>
        <div class="library-portal">        
            <button class="library-portal-btn" onclick='window.location.href="<?=URLROOT . "/Home/Portal"?>"'>
                <img src="<?=URLROOT . "/public/assets/Library.jpeg"?>" alt="Chilaw Library" class="library-img">
                <a href="#" class="library-txt">Chilaw Public Library</a>
            </button>
        </div>
        <div class="events">
            <a href="#"><h3>Upcoming Events</h3></a>
            <hr>
            <div class="event-item">
                <p>20 March 2023</p>
                <hr>
                <a href="#"><p>CHRISTMAS  CELEBRATIONS</p></a>
            </div>
            <div class="event-item">
                <p>13 February 2023</p>
                <hr>
                <a href="#"><p>NEW-YEAR CELEBRATIONS</p></a>
            </div>
            <button class="more btn" onclick='window.location.href="<?=URLROOT . "/Posts/Events"?>"'>More</button>
        </div>
    </div>

    <style>
        .sabha-img{
            background: url("<?=URLROOT . '/public/assets/logo.jpg'?>");
            background-position: center;
            background-repeat: no-repeat;
            background-size: contain;
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

        <div class="projects">
            <div class="project-header">
                <a href="#"><h2 class="project-txt">Ongoing Projects</h2></a>
                <button class="more btn" onclick='window.location.href="<?=URLROOT . "/Posts/Projects"?>"'>More</button>    
            </div>
            
            <hr>
            <div class="project-items">
                <div class="project-item">
                    <img src="<?=URLROOT . "/public/assets/logo.jpg"?>" alt="logo" class="sabha-img">
                    <a href="#"><h3>UNICEF Project</h3></a>
                    <hr>
                    <p>21 January 2023</p>
                </div>
                <div class="project-item">
                    <img src="<?=URLROOT . "/public/assets/logo.jpg"?>" alt="logo" class="sabha-img">
                    <a href="#"><h3>Wastewater Management Project</h3></a>
                    <hr>
                    <p>14 January 2023</p>
                </div>
                <div class="project-item">
                    <img src="<?=URLROOT . "/public/assets/logo.jpg"?>" alt="logo" class="sabha-img">
                    <a href="#"><h3>Worldbank Project</h3></a>
                    <hr>
                    <p>1 February 2023</p>
                </div>
            </div>

        </div>

    </div>

    <div class="right-content">
        <div class="ward-map">
            <h3 class="ward-map-txt">WARD MAP</h3>
            <img src="<?=URLROOT . "/public/assets/wardmap.png"?>" alt="" class="ward-map-img">
        </div>
        <div class="emergency-numbers">
            <a href="<?=URLROOT . "/Home/emergency"?>"><h3>Emergency Numbers</h3></a>
            <hr>
            <a href="#"><p class="emergency-item">Fire & Rescue / Ambulance</p></a>
            <a href="#"><p class="emergency-item">Other Emergency Numbers</p></a>
        </div>
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