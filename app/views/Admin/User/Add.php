<div class="content">
    <h1>
        Add New Staff User
    </h1>
    <hr>
    <div class="formContainer">
        <?php if($data['Add'])
                if(!$data['Add']['success'])
                    echo "Failed to add user ".$data['Add']['errmsg'];
                else
                    echo "Added Successfully";
        ?>
        <form class="fullForm" method="post">
            <div class="inputfield">
                <label for="email">User's email</label>
                <div class="inputDiv">
                    <input type="email" id="email" name="email" placeholder="Enter User's email" required>
                </div>
            </div>

            <div class="inputfield">
                <label for="name">Name</label>
                <div class="inputDiv">
                    <input type="text" name="name" id="name" placeholder="Enter User's Name" required>
                </div>
            </div>

            <div class="inputfield">
                <label for="password">Password (Demo only)</label>
                <div class="inputDiv">
                    <input type="password" name="password" id="password" placeholder="Enter Password" required>
                </div>
            </div>

            <div class="inputfield">
                <label for="address">Address</label>
                <div class="inputDiv">
                    <input type="text" name="address" id="address" placeholder="Enter User's address" required>
                </div>
            </div>

            <div class="inputfield">
                <label for="contact_no">User's contact number</label>
                <div class="inputDiv">
                    <input type="tel" id="contact_no" name="contact_no" maxlength="12" pattern="(\+94\d{9})|\d{10}" required>
                </div>
            </div>

            <div class="inputfield">
                <label for="nic">NIC</label>
                <div class="inputDiv">
                    <input type="text" name="nic" id="nic" placeholder="Enter User's nic" required>
                </div>
            </div>

            <div class="inputfield">
                <label for="role">User's Role</label>
                <div class="inputDiv">
                    <select id="role" name="role">
                        <?php 
                            $roles = ['LibraryStaff'=>'Library Staff Member','ComplaintHandler'=>'Complaint Handler'];
                            foreach($roles as $role=>$name):
                        ?>
                        <option value="<?=$role?>"><?=$name?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="submitButtonContainer">
                <div class="submitButton">
                    <input type="submit" id="Add" value="Add User" name="Add">
                </div>
            </div>
        </form>
    </div>
</div>