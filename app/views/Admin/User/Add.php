<?php
$errors = $data['errors'] ?? false;
$old = $data['old'] ?? false;
?>
<div class="content">
    <h1>
        Add New Staff User
    </h1>
    <hr>
    <div class="formContainer">
    <?php 
    if ($data['Add'] ?? false):
        if (!$data['Add']['success']): 
            $message = "Failed to add user " . $data['Add']['errmsg'];
            Errors::generic($message);
        else: ?>
            <div class="success">
                Added new user <b>"<?=
                    ($old['name']??'name') . '(' .( $old['email']??'email') . ')'
                ?>"</b> Successfully!
            </div>
        <?php endif;
    endif; ?>
        <form class="fullForm" method="post">
        <?php Errors::validation_errors($errors,[
                'email' => "New user's email",
                'name' => 'New user\'s name',
                'address' => 'Address',
                'contact_no' => 'Contact number',
                'nic' => 'NIC Number',
                'role' => 'User\'s role',
            ]); 

            Text::email('New user\'s email', 'email', 'email',
                        placeholder:'Enter new user\'s email',
                        value:$old['email'] ?? null);
            Text::text('New user\'s name', 'name', 'name',
                        placeholder:'Enter new user\'s name', maxlength:255,
                        value:$old['name'] ?? null);
            Text::password('Password(DEMO ONLY)', 'password', 'password',
                        placeholder:'Enter a password',
                        value:$old['password'] ?? null);
            Text::text('Address', 'address', 'address',
                        placeholder:'Enter new user\'s address', maxlength:255,
                        value:$old['address'] ?? null);
            Text::text('Contact number', 'contact_no', 'contact_no',
                        '+94XXXXXXXXX or 0XXXXXXXXX', type:'tel', maxlength:12,
                        pattern:"(\+94\d{9})|0\d{9}", value:$old['contact_no'] ?? null);
            // TODO: Redo regex for nic
            Text::text('NIC', 'nic', 'nic', 'XXXXXXXXXXXX or XXXXXXXXXV',
                        maxlength:12,pattern:"(\d{12})|(\d{10}(V|v))",
                        value:$old['nic'] ?? null);
            // ? Maybe do this in controller
            $roles = [];
            foreach ($data['roles'] as $role) {
                $roles[$role['staff_type_id']] = $role['staff_type'];
            }

            Group::select('Role', 'role', $roles, 'role',
                        selected:$old['role'] ?? null);

            Other::submit('Add','add',value:'Add User'); ?>
        </form>
    </div>
</div>
<script>
    expandSideBar('sub-items-user');
</script>