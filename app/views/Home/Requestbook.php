
    <div class="head-area">
    <h1>New Book Request</h1>
    <hr>
    </div>

    <div class="formContainer">
        <form class="fullForm" action="<?=URLROOT . "/LibraryMember/bookRequest"?>" method="post">
            <div class="inputfield">
                <label for="textInput">Title of the Book: </label>
                <div class="inputDiv">
                    <input type="text" name="textInputField" id="textInput" placeholder="Enter Book name">
                </div>
            </div>

            <div class="inputfield">
                <label for="textInput">Author of the Book: </label>
                <div class="inputDiv">
                    <input type="text" name="textInputField" id="textInput" placeholder="Enter Author name">
                </div>
            </div>

            <div class="inputfield">
                <label for="textInput">ISBN of the Book: </label>
                <div class="inputDiv">
                    <input type="text" name="textInputField" id="textInput" placeholder="Enter ISBN">
                </div>
            </div>

            <div class="inputfield">
                <label for="noteInput">Reason for requesting:</label>
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
