<?php 
$post = isset($data['Announcement']['result'][0])?$data['Announcement']['result'][0]:false;
if(!$post): ?>
<h1>
    Invalid Post
</h1>
<?php else: ?>
<h1>
    <?=$post['title']?>
</h1>
<div class="details">
    <div class="author">
        <?=$post['author']?>
    </div>
    <div class='date'>
        <?=implode('/',explode('-',$post['date']))?>
    </div>
    <div class='category'>
        <a href="#">
            <?=$post['category']?>
        </a>
    </div>
</div>
<hr />
<!-- Only if images exist -->
<div class="slideshow-container">
    <div class="slideshow">
        <img src="" alt="slideshow" id="slideshow">
        <button  class="slideshow-btn left-btn" onclick='prev(["<?=URLROOT . "/public/assets/sabha1.jpg"?>","<?=URLROOT . "/public/assets/sabha2.jpg"?>"])'>&#10094;</button>
        <button  class="slideshow-btn right-btn" onclick='next(["<?=URLROOT . "/public/assets/sabha1.jpg"?>","<?=URLROOT . "/public/assets/sabha2.jpg"?>"])'>&#10095;</button>
    </div>
</div>
<p>
    <?=$post['description']?>
</p>
<div class="attachments">
    <div class="heading">
        Attachments
    </div>
    <div class="links">
        <a href="#">file1.pdf</a>
        <a href="#">file1.pdf</a>
        <a href="#">file1.pdf</a>
        <a href="#">file1.pdf</a>
        <a href="#">file1.pdf</a>
    </div>
</div>
<?php endif; ?>

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

