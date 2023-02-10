<div class="content">
    <?php if($data['staff'] ):
            if($data['staff']['error'] || $data['staff']['nodata']):?>
                <h1>
                    <?=$data['staff']['nodata']?'staff Not found':
                    $data['staff']['errmsg']?>
                </h1>
            <?php else: 
            // var_dump($data);
            $stf = $data['staff']['result'][0];?>
    <h1>
        Edit Staff User
    </h1>
    <hr>
    <div class="formContainer">
        <?php if(isset($data['edit'])):
                if(!$data['edit']['user']['success']):
                    echo "Failed to Edit user ".$data['edit']['user']['errmsg'];
                else:
                    echo "Saved changes";
                endif;
            endif;
        ?>
        <form class="fullForm" method="post">
            <div class="inputfield">
                <label for="email">User's email</label>
                <div class="inputDiv">
                    <input type="email" id="email" name="email" placeholder="Enter User's email" value="<?=$stf['email']?>" required>
                </div>
            </div>

            <div class="inputfield">
                <label for="name">Name</label>
                <div class="inputDiv">
                    <input type="text" name="name" id="name" placeholder="Enter User's Name"  value="<?=$stf['name']?>" required>
                </div>
            </div>

            <div class="inputfield">
                <label for="address">Address</label>
                <div class="inputDiv">
                    <input type="text" name="address" id="address" placeholder="Enter User's address"  value="<?=$stf['address']?>"required>
                </div>
            </div>

            <div class="inputfield">
                <label for="contact_no">User's contact number</label>
                <div class="inputDiv">
                    <input type="tel" id="contact_no" name="contact_no" value="<?=$stf['contact_no']?>" maxlength="12" pattern="(\+94\d{9})|\d{10}" required>
                </div>
            </div>

            <div class="submitButtonContainer">
                <div class="submitButton">
                    <input type="submit" id="Edit" value="Save Changes" name="Edit">
                </div>
            </div>
        </form>
    </div>
    <?php endif; else:?>
        NO ID GIVEN
    <?php endif;?>
</div>