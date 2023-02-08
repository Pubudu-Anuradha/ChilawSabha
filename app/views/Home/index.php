<h1>Test</h1>
<div class="slideshow">

    <img src="" alt="slideshow" id="slideshow">

    <button  class="slideshow-btn left-btn" onclick='prev(["<?=URLROOT . "/public/assets/sabha1.jpg"?>","<?=URLROOT . "/public/assets/sabha2.jpg"?>"])'>&#10094;</button>
    <button  class="slideshow-btn right-btn" onclick='next(["<?=URLROOT . "/public/assets/sabha1.jpg"?>","<?=URLROOT . "/public/assets/sabha2.jpg"?>"])'>&#10095;</button>

</div>
<h2>Links</h2>
    <a href="<?=URLROOT . "/References/"?>> References </a> <br>
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