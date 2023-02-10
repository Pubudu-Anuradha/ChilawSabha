<div class="content">
    <div class="adduserform">
        <h2 class="addusers-topic">Edit Users </h2>
        <form action="<?= URLROOT . "/LibraryStaff/editusers" ?>" class="add-user-form">
            <div class="field">
                <label for="memid">Membership ID</label>
                <input type="text" name="memid" id="memid" required>
            </div>
            <div class="field">
                <label for="fname">First Name</label>
                <input type="text" name="fname" id="fname" maxlength="255" required>
            </div>
            <div class="field">
                <label for="lname">Last Name</label>
                <input type="text" name="lname" id="lname" maxlength="255" required>
            </div>
            <div class="field">
                <label for="email">Email</label>
                <input type="text" name="email" id="email" maxlength="255" required>
            </div>
            <div class="field">
                <label for="telno">Contact No</label>
                <input type="tel" name="telno" id="telno" maxlength="12" required>
            </div>
            <div class="field">
                <label for="address">Address</label>
                <input type="text" name="address" id="address"  maxlength="255" required >
            </div>
            <div class="field submit-field">
                <input type="submit" name="Submit" value="Confirm" class="submit-btn">
            </div>
        </form>
    </div>
</div>