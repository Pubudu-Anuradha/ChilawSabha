<div class="content">
    <div class="page">
        <h2 class="topic">Edit Users </h2>
        <form action="<?= URLROOT . "/LibraryStaff/editusers" ?>" class="fullForm">
            <div class="inputfield">
                <label for="memid">Membership ID</label>
                <input type="text" name="memid" id="memid" required>
            </div>
            <div class="inputfield">
                <label for="fname">First Name</label>
                <input type="text" name="fname" id="fname" maxlength="255" required>
            </div>
            <div class="inputfield">
                <label for="lname">Last Name</label>
                <input type="text" name="lname" id="lname" maxlength="255" required>
            </div>
            <div class="inputfield">
                <label for="email">Email</label>
                <input type="text" name="email" id="email" maxlength="255" required>
            </div>
            <div class="inputfield">
                <label for="telno">Contact No</label>
                <input type="tel" name="telno" id="telno" maxlength="12" required>
            </div>
            <div class="inputfield">
                <label for="address">Address</label>
                <input type="text" name="address" id="address"  maxlength="255" required >
            </div>
            <div class="submitButtonContainer">
                <div class="submitButton">
                    <input type="submit" name="Submit" value="Confirm" class="submit-btn">
                </div>
            </div>
        </form>
    </div>
</div>