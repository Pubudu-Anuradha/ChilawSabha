<div class="formContainer">
    <form class="fullForm" method="post">
        <div class="inputfield">
            <label for="textInput">Text Input: </label>
            <div class="inputDiv">
                <input type="text" name="textInputField" id="textInput" placeholder="Enter Text">
            </div>
        </div>

        <div class="inputfield">
            <label for="passwordInput">Password Input: </label>
            <div class="inputDiv">
                <input type="password" name="passwordInputField" id="passwordInput" placeholder="Enter Password">
            </div>
        </div>

        <div class="inputfield">
            <label for="selectOption">Choose a name:</label>
            <div class="inputDiv">
                <select id="selectOption" name="selectOptionField">
                    <option value="Pubudu">Pubudu</option>
                    <option value="Hasala">Hasala</option>
                    <option value="Sandaru">Sandaru</option>
                    <option value="Tharindu">Tharindu</option>
                </select>
            </div>
        </div>

        <div class="inputfield">
            <p>Checkbox Select: </p>

            <div class="checkboxInputs">
                <input type="checkbox" name="checkboxInputField1" id="checkboxInput1">
                <label for="checkboxInput1">Pubudu </label>

                <input type="checkbox" name="checkboxInputField2" id="checkboxInput2">
                <label for="checkboxInput2">Hasala </label>

                <input type="checkbox" name="checkboxInputField3" id="checkboxInput3">
                <label for="checkboxInput3">Sandaru </label>

                <input type="checkbox" name="checkboxInputField4" id="checkboxInput4">
                <label for="checkboxInput4">Tharindu </label>
            </div>
        </div>

        <div class="inputfield">
            <p>Radio Button Select: </p>

            <div class="radiobuttonInputs">
                <input type="radio" name="radiobuttonInputField" id="radiobuttonInput1" value="Pubudu">
                <label for="radiobuttonInput1">Pubudu</label>

                <input type="radio" name="radiobuttonInputField" id="radiobuttonInput2" value="Hasala">
                <label for="radiobuttonInput2">Hasala</label>

                <input type="radio" name="radiobuttonInputField" id="radiobuttonInput3" value="Sandaru">
                <label for="radiobuttonInput3">Sandaru</label>

                <input type="radio" name="radiobuttonInputField" id="radiobuttonInput4" value="Tharindu">
                <label for="radiobuttonInput4">Tharindu</label>
            </div>
        </div>

        <div class="inputfield">
            <label for="dateInput">Birthday: </label>
            <div class="inputDiv">
                <input type="date" id="dateInput" name="dateInputField">
            </div>
        </div>

        <div class="inputfield">
            <label for="dateTimeLocalInput">Attend (date and time): </label>
            <div class="inputDiv">
                <input type="datetime-local" id="dateTimeLocalInput" name="dateTimeLocalInputField">
            </div>
        </div>

        <div class="inputfield">
            <label for="emailInput">Enter your email: </label>
            <div class="inputDiv">
                <input type="email" id="emailInput" name="emailInputField">
            </div>
        </div>

        <div class="inputfield">
            <label for="fileInput">Select a file:</label>
            <input type="file" id="fileInput" name="fileInputField">
        </div>

        <div class="inputfield">
            <label for="numberInput">Quantity (between 3 and 5):</label>
            <div class="inputDiv">
                <input type="number" id="numberInput" name="NumberInputField" min="3" max="5">
            </div>
        </div>

        <div class="inputfield">
            <label for="phoneInput">Enter your phone number:</label>
            <div class="inputDiv">
                <input type="tel" id="phoneInput" name="phoneInputField" maxlength="12" pattern="(\+94\d{9})|\d{10}">
            </div>
        </div>

        <div class="inputfield">
            <label for="searchInput">Search Google:</label>
            <div class="inputDiv">
                <input type="search" id="searchInput" name="searchInputField">
            </div>
        </div>

        <div class="inputfield">
            <label for="timeInput">Select a time:</label>
            <div class="inputDiv">
                <input type="time" id="timeInput" name="timeInputField">
            </div>
        </div>

        <div class="inputfield">
            <label for="noteInput">Enter a note:</label>
            <div class="inputDiv">
                <textarea id="noteInput" name="message" rows="10" cols="30"></textarea>
            </div>
        </div>

        <div class="submitButtonContainer">
            <div class="submitButton">
                <input type="submit" id="submit" value="Submit">
            </div>
        </div>
    </form>
</div>

<script src="<?=URLROOT . "/public/js/homeTest.js"?>"></script>