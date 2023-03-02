<div class="head-area">
  <h1>WELCOME TO CHILAW PUBLIC LIBRARY</h1>
  <hr>
</div>

<?php Slideshow::Slideshow([URLROOT . "/public/assets/sabha1.jpg",URLROOT . "/public/assets/sabha2.jpg"]);?>

<div class="portal-intro">
  <p >Welcome to the Chilaw Public Library Online Portal. 
  The library has more than 10,000 books that you can search and find copies. 
  If you are a library member you can log in to your dashboard and access many other features. 
  Contact the Librarian if there is any problem or Technical error.</p>
</div>

<div class="portal-buttonsContainer">
  <div class="button-container">
    <img src="<?= URLROOT . '/public/assets/user.png' ?>" class="portal-button-icons" alt="book">
    <a href="<?= URLROOT . '/Home/bookCatalogue' ?>"><button class="portal-button">View Book Catalogue</button></a>
  </div>

  <div class="button-container">
    <img src="<?= URLROOT . '/public/assets/user.png' ?>" class="portal-button-icons" alt="book">
    <a href="<?= URLROOT . '/Home/bookRequest' ?>"><button class="portal-button">Request a book</button></a>
  </div>

  <div class="button-container">
    <img src="<?= URLROOT . '/public/assets/user.png' ?>" class="portal-button-icons" alt="book">
    <a href="<?= URLROOT . '/ContactUs/' ?>"><button class="portal-button">Contact Librarian</button></a>
  </div>

  <div class="button-container">
    <img src="<?= URLROOT . '/public/assets/user.png' ?>" class="portal-button-icons" alt="book">
    <a href="<?= URLROOT . '/Login' ?>"><button class="portal-button">Login</button></a>
  </div>
</div>

<div class="portal-otherButtons">
  <h2>More details:</h2>
  <a href="#"><button class="portal-otherButton">Membership Application form</button></a>
  <a href="#"><button class="portal-otherButton">Membership Renewal Form</button></a>
  <a href="#"><button class="portal-otherButton">Rules & Regulations</button></a>
  <a href="#"><button class="portal-otherButton">Location</button></a>
</div>
