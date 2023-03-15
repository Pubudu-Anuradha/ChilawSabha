<div class="content">
    <div class="page">
        <h2 class="topic">Edit Users </h2>
        <div class="formContainer">
            <form action="<?= URLROOT . "/LibraryStaff/editusers" ?>" class="fullForm">
                <div class="input-field">
                    <label for="memid">Membership ID</label>
                    <div class="input-wrapper">
                        <input type="text" name="memid" id="memid" required>
                        <span></span>
                    </div>   
                </div>
                <div class="input-field">
                    <label for="fname">First Name</label>
                    <div class="input-wrapper">
                        <input type="text" name="fname" id="fname" maxlength="255" required>
                        <span></span>
                    </div> 
                </div>
                <div class="input-field">
                    <label for="lname">Last Name</label>
                    <div class="input-wrapper">
                        <input type="text" name="lname" id="lname" maxlength="255" required>
                        <span></span>
                    </div> 
                </div>
                <div class="input-field">
                    <label for="email">Email</label>
                    <div class="input-wrapper">
                        <input type="text" name="email" id="email" maxlength="255" required>
                        <span></span>
                    </div> 
                </div>
                <div class="input-field">
                    <label for="telno">Contact No</label>
                    <div class="input-wrapper">
                        <input type="tel" name="telno" id="telno" maxlength="12" required>
                        <span></span>
                    </div> 
                </div>
                <div class="input-field">
                    <label for="address">Address</label>
                    <div class="input-wrapper">
                        <input type="text" name="address" id="address"  maxlength="255" required >
                        <span></span>
                    </div> 
                </div>
                <div class="submitButtonContainer">
                    <div class="submitButton">
                        <input type="submit" name="Submit" value="Confirm" class="submit-btn">
                    </div>
                </div>
            </form>
        </div>
        
    </div>
</div>