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