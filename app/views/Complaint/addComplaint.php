<div class="form">
    <div class="complaint-form">
        <h2>
            Complaint Form
        </h2>

        <!-- check whether data added or not -->
        <div class="formContainer">
            <?php if ($data['Submit'])
                if (!$data['Submit']['success'])
                    echo "Failed to add Complaint " . $data['Submit']['errmsg'];
                else
                    echo "Added Successfully";
            ?>

            <div class="formContainer">
                <form id="complaint" name="complaint form" class="fullForm" method="post">

                    <div class="inputfield">
                        <label for="name">Complainer Name: </label>
                        <div class="inputDiv">
                            <input type="text" id="name" name="name" placeholder="Enter Name">
                        </div>
                    </div>

                    <div class="inputfield">
                        <label for="email">Enter your email: </label>
                        <div class="inputDiv">
                            <input type="email" id="email" name="email" placeholder="Enter Email">
                        </div>
                    </div>

                    <div class="inputfield">
                        <label for="phone_number">Enter your phone number:</label>
                        <div class="inputDiv">
                            <input type="tel" id="phone_number" name="phone_number" maxlength="12" pattern="(\+94\d{9})|\d{10}" placeholder="Enter Phone Number">
                        </div>
                    </div>

                    <div class="inputfield">
                        <label for="address">Address: </label>
                        <div class="inputDiv">
                            <input type="text" id="address" name="address" placeholder="Enter Address">
                        </div>
                    </div>

                    <div class="inputfield">
                        <label for="category">Choose a name:</label>
                        <div class="inputDiv">
                            <select id="category" name="category">
                                <?php $categories = ['Garbage disposal', 'Land issues', 'Unauthorized construction', 'Street lamp', 'Roads require repair', 'Damaged public infrastructure'];
                                foreach ($categories as $category) : ?>
                                    <option value="<?= $category ?>"><?= $category ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="inputfield">
                        <label for="message">Briefly Describe your incident:</label>
                        <div class="inputDiv">
                            <textarea id="message" name="message" rows="10" cols="30" placeholder="A short desription about the complaint" required></textarea>
                        </div>
                    </div>

                    <!-- <div class="inputfield">
                <label for="file">Select a file:</label>
                <input type="file" id="file" name="file">
            </div> -->
                    <div class="submitButtonContainer">
                        <div class="submitButton">
                            <input type="submit" id="Submit" value="Submit" name="Submit">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>