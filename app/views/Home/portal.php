<div class="head-area">
  <h1>WELCOME TO CHILAW PUBLIC LIBRARY</h1>
  <hr>
</div>

<div class="slideshow">

    <img src="" alt="slideshow" id="slideshow">

    <button  class="slideshow-btn left-btn" onclick='prev(["<?=URLROOT . "/public/assets/sabha1.jpg"?>","<?=URLROOT . "/public/assets/sabha2.jpg"?>"])'>&#10094;</button>
    <button  class="slideshow-btn right-btn" onclick='next(["<?=URLROOT . "/public/assets/sabha1.jpg"?>","<?=URLROOT . "/public/assets/sabha2.jpg"?>"])'>&#10095;</button>

</div>

<div class="portal-intro">
  <p >Welcome to the Chilaw Public Library Online Portal. 
  The library has more than 10,000 books that you can search and find copies. 
  If you are a library member you can log in to your dashboard and access many other features. 
  Contact the Librarian if there is any problem or Technical error.</p>
</div>

<div class="portal-buttonsContainer">
  <a href="<?=URLROOT . "/Home/bookcatalog"?>"><button class="portal-button">View Book Catalogue</button></a>
  <a href="<?=URLROOT . "/Home/requestbook"?>"><button class="portal-button">Request a book</button></a>
  <a href="<?=URLROOT . "/ContactUs/"?>"><button class="portal-button">Contact Librarian</button></a>
  <a href="<?=URLROOT . "/Login/"?>"><button class="portal-button">Login</button></a>
</div>

<div class="portal-otherButtons">
  <h2>More details:</h2>
  <a href="#"><button class="portal-otherButton">Membership Application form</button></a>
  <a href="#"><button class="portal-otherButton">Membership Renewal Form</button></a>
  <a href="#"><button class="portal-otherButton">Rules & Regulations</button></a>
  <a href="#"><button class="portal-otherButton">Location</button></a>
</div>

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