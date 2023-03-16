<?php

class Slideshow{
    public static function Slideshow($images = [], $class = null){
?>
        <div class="slideshow<?= $class ? ' '.$class : '' ?>">
                <img src="" alt="slideshow" id="slideshow">
            <?php if(count($images) > 1): ?>
                <button  class="slideshow-btn left-btn"
                    onclick='prev(<?=json_encode($images)?>)'>&#10094;</button>
                <button  class="slideshow-btn right-btn"
                    onclick='next(<?=json_encode($images)?>)'>&#10095;</button>
            <?php endif; ?>
        </div>
        <script src="<?=URLROOT.'/public/js/slideshow.js'?>"></script>
        <script>slideshow(<?=json_encode($images)?>);</script>
    <?php }
}