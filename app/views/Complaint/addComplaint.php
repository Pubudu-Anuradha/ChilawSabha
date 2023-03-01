<div class="form">
    <div class="side-menu">
        <h1></h1>
    </div>
    <div class="complaint-form">
        <h2>
            Complaint Form <hr class="hr1">
        </h2>
        <!-- <?php var_dump($data); ?> -->
        <div class="formContainer">
            <form id="complaint" name="complaint form" class="fullForm" action="<?=URLROOT . "/Complaint/addComplaint"?>" method="post">
            <?php if (isset($data['message'])) {echo $data['message'] . '<br>';}?>
            <div class="inputfield">
                <label for="textInput">Complainer Name: </label>
                <div class="inputDiv">
                    <input type="text" name="nameInputField" id="textInput" placeholder="Enter Name">
                </div>
            </div>

            <div class="inputfield">
                <label for="emailInput">Enter your email: </label>
                <div class="inputDiv">
                    <input type="email" id="emailInput" name="emailInputField" placeholder="Enter Email">
                </div>
            </div>

            <div class="inputfield">
                <label for="phoneInput">Enter your phone number:</label>
                <div class="inputDiv">
                    <input type="tel" id="phoneInput" name="phoneInputField" maxlength="12" pattern="(\+94\d{9})|\d{10}" placeholder="Enter Phone Number">
                </div>
            </div>

            <div class="inputfield">
                <label for="textInput">Address: </label>
                <div class="inputDiv">
                    <input type="text" name="addressInputField" id="textInput" placeholder="Enter Address">
                </div>
            </div>

            <div class="inputfield">
                <label for="selectOption">Choose a name:</label>
                <div class="inputDiv">
                    <select id="selectOption" name="selectOptionField">
                        <option value="Garbage disposal">Garbage disposal</option>
                        <option value="Land issues">Land issues</option>
                        <option value="Unauthorized construction">Unauthorized construction</option>
                        <option value="Street lamp">Street lamp</option>
                        <option value="Roads require repair">Roads require repair</option>
                        <option value="Damaged public infrastructure">Damaged public infrastructure</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>

            <div class="inputfield">
                <label for="noteInput">Briefly Describe your incident:</label>
                <div class="inputDiv">
                    <textarea id="noteInput" name="messageInputField" rows="10" cols="30"></textarea>
                </div>
            </div>

            <div class="inputfield">
                <label for="noteInput">Date:</label>
                <div class="inputDiv">
                    <input id="noteInput" name="dateInputField" placeholder="Date" type="date" required>

                </div>
            </div>

            <div class="inputfield">
                <label for="fileInput">Select a file:</label>
                <input type="file" id="fileInput" name="fileInputField">
            </div>


            <div class="submitButtonContainer">
                <div class="submitButton">
                    <input name="submit" type="submit" id="submit" value="Submit">
                </div>
            </div>
            </form>
        </div>
    </div>
</div>








