<?php
$users = $data['Users']['result'][0] ?? null;
$errors = $data['errors'] ?? false;
?>

<div class="content">
    <div class="page">
        <h2 class="topic">Edit Library Member</h2>
        <?php if(!is_null($users)): ?>
            <div class="formContainer">
                <?php if ($data['edit'] ?? false) {
                    if (!$data['edit']['success']) {
                        echo "Failed To Edit User " . $data['edit']['errmsg'];
                    } else {
                        echo "Changes saved Successfully";
                    }
                }?>

                <form  class="fullForm" method="post">

                        <?php Errors::validation_errors($errors, [
                            'email' => "User Email",
                            'name' => 'User Name',
                            'address' => 'Address',
                            'contact_no' => 'Contact number',
                        ]);

                        Text::text('User Name', 'name', 'name', value:$users['name'],
                                    placeholder:'Enter new user\'s name', maxlength:255);                        
                        Text::email('User Email', 'email', 'email',required:true, value:$users['email'],
                                    placeholder:'Enter new user\'s email');
                        Text::text('Address', 'address', 'address', value:$users['address'],
                                    placeholder:'Enter new user\'s address', maxlength:255);
                        Text::text('Contact number', 'contact_no', 'contact_no', value:$users['contact_no'],
                                    placeholder:'+94XXXXXXXXX or 0XXXXXXXXX', type:'tel', maxlength:12,
                                    pattern:"(\+94\d{9})|0\d{9}");
                        Other::submit('Edit','edit',value:'Save Changes');

                        ?>
                </form>
            </div>
        <?php else:?>
            ERROR RETRIEVING LIBRARY MEMBER INFORMATION
        <?php endif;?>
    </div>
</div>

<script>
    expandSideBar("sub-items-user","see-more-usr");

    //TO DO: add edit history
</script>