<?php
$errors = $data['errors'] ?? false;
?>

<div class="content">
    <div class="page">
        <h2 class="topic">Add Library Member</h2>
        <div class="formContainer">
            <?php if ($data['Add'] ?? false) {
                if (!$data['Add']['success']) {
                    echo "Failed To Add User " . $data['Add']['errmsg'];
                } else {
                    echo "<span class='green'>User Added Successfully</span>";
                }
            }?>

            <form  class="fullForm" method="post">

                    <?php Errors::validation_errors($errors, [
                        'membership_id'=>'Membership ID',
                        'email' => "User Email",
                        'name' => 'User Name',
                        'address' => 'Address',
                        'contact_no' => 'Contact number',
                    ]);

                    Other::number('Membership ID', 'membership_id', 'membership_id',
                                placeholder:'Enter new user\'s Membership ID', min:0);
                    Text::text('User Name', 'name', 'name',
                                placeholder:'Enter new user\'s name', maxlength:255);
                    Text::email('User Email', 'email', 'email',required:true,
                                placeholder:'Enter new user\'s email');
                    Text::text('Address', 'address', 'address',
                                placeholder:'Enter new user\'s address', maxlength:255);
                    Text::text('Contact number', 'contact_no', 'contact_no',
                                placeholder:'+94XXXXXXXXX or 0XXXXXXXXX', type:'tel', maxlength:12,
                                pattern:"(\+94\d{9})|0\d{9}");
                    Other::submit('Add','add',value:'Add User');

                    ?>
            </form>
        </div>

    </div>
</div>

<script>
    expandSideBar("sub-items-user","see-more-usr");
</script>