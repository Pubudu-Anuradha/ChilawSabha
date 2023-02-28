<?php

class Slideshow{

    public static function Slideshow($images = []){
?>
        <div class="slideshow">

        <img src="" alt="slideshow" id="slideshow">

        <button  class="slideshow-btn left-btn" onclick='prev(<?=json_encode($images)?>)'>&#10094;</button>
        <button  class="slideshow-btn right-btn" onclick='next(<?=json_encode($images)?>)'>&#10095;</button>

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

        slideshow(<?=json_encode($images)?>);

        </script>

    <?php }
}