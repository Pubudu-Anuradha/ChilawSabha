<div class="head-area">
  <h1>WELCOME TO CHILAW PUBLIC LIBRARY</h1>
  <hr>
</div>

<?php Slideshow::Slideshow([URLROOT . "/public/assets/sabha1.jpg",URLROOT . "/public/assets/sabha2.jpg"]);?>

<div class="portal-main">

  <div class="portal-content">

    <div class="portal-intro">
      <p >Welcome to the Chilaw Public Library Online Portal.
      The library has more than 10,000 books that you can search and find copies.
      If you are a library member you can log in to your dashboard and access many other features.
      Contact the Librarian if there is any problem or Technical error.</p>
    </div>

    <div class="portal-buttonsContainer">
      <div class="button-container">
        <img src="<?= URLROOT . '/public/assets/open-book.png' ?>" class="portal-button-icons" alt="book">
        <a href="<?= URLROOT . '/Home/bookCatalogue' ?>"><button class="portal-button">Book Catalogue</button></a>
      </div>

      <div class="button-container">
        <img src="<?= URLROOT . '/public/assets/call.png' ?>" class="portal-button-icons" alt="book">
        <a href="<?= URLROOT . '/ContactUs/#lib-contact' ?>"><button class="portal-button">Contact Librarian</button></a>
      </div>

      <div class="button-container">
        <img src="<?= URLROOT . '/public/assets/user.png' ?>" class="portal-button-icons" alt="book">
        <a href="<?= URLROOT . '/Login' ?>"><button class="portal-button">Login</button></a>
      </div>
    </div>

  </div>

  <div class="reference-lib">
    <a href="<?= URLROOT . '/Home/bookRequest' ?>"><button class="portal-button-req">Request a book</button></a>
    <div class="portal-otherButtons">
      <!-- TO DO - add real documents which will force download when clicked -->
      <a href="<?=URLROOT . '/Downloads/file/MembershipApplicationForm.pdf'?>"><button class="portal-otherButton">Membership Application form</button></a>
      <a href="<?=URLROOT . '/Downloads/file/RenewalForm.pdf'?>"><button class="portal-otherButton">Membership Renewal Form</button></a>
      <a href="<?=URLROOT . '/Downloads/file/RulesAndRegulations.pdf'?>"><button class="portal-otherButton">Rules & Regulations</button></a>
      <a href="<?= URLROOT . '/ContactUs/#lib-contact' ?>"><button class="portal-otherButton">Location</button></a>
    </div>

  </div>

</div>
