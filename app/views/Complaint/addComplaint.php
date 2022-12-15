<?php

require_once 'Header.php';
require_once 'Options.php';

?>




<div class="complaint-form">
    <h1>
        Complaint Form
    </h1>
    <hr class="hr1">
    <br>

    <form id="complaint" method="post" class="form" name="complaint form" accept-charset="utf-8" action="<?=URLROOT . "/Complaint/addComplaint"?>">

        <?php if (isset($data['message'])) {
    echo $data['message'] . '<br>';
}?>

        <p>Complainer Name</p>
        <input class="form-control" id="name" name="name" placeholder="Name" type="text" required>
        <p>Email Address</p>
        <input class="form-control" id="email" name="email" placeholder="Email" type="text" required>
        <p>Mobile Number</p>
        <input class="form-control" id="mobi_num" name="mobi_num" placeholder="Number" type="text" maxlength="12" required>
        <p>Address</p>
        <input class="form-control" id="address" name="address" placeholder="Address" type="text" required>
        <p>Date</p>
        <input class="form-control" id="date" name="date" placeholder="Date" type="date" required>
        <p>Category</p>
        <select class="form-control" id="category" name="category" id="category">
            <option value="Garbage disposal">Garbage disposal</option>
            <option value="Land issues">Land issues</option>
            <option value="Unauthorized construction">Unauthorized construction</option>
            <option value="Street lamp">Street lamp</option>
            <option value="Roads require repair">Roads require repair</option>
            <option value="Damaged public infrastructure">Damaged public infrastructure</option>
            <option value="Other">Other</option>
        </select>

        <p>Message</p>
        <textarea class="form-control" name="message" id="message" placeholder="Message" cols="30" rows="10"></textarea>
        <p>Upload Images</p>
        <input type="file" name="image" id="image">
        <input id="submit" name="submit" type="submit" value="Submit">
        <br><br> <br>


    </form>

</div>

<?php

require_once 'Footer.php';
?>