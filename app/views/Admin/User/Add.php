<?php
$errors = $data['errors'] ?? false;
$old = $data['old'] ?? false;

$warn = function($message,$err_name,$_field = false) use(&$errors) {
    if($err_name == 'empty' || $err_name == 'missing'){
        if(array_search($_field,$errors['empty']??[])!==false || array_search($_field,$errors['missing']??[])){ ?>
            <div class="error">
                <?=$message?>
            </div>
        <?php }
    }else if((!$_field && ($errors[$err_name] ?? false)) ||
       ($_field && ($errors[$err_name][$_field] ?? false))){ ?>
        <div class="error">
            <?=$message?>
        </div>
    <?php }}
?>
<div class="content">
    <h1>
        Add New Staff User
    </h1>
    <hr>
    <div class="formContainer">
<?php if ($data['Add'] ?? false) {
    if (!$data['Add']['success']) {
        echo "Failed to add user " . $data['Add']['errmsg'];
    } else {
        echo "Added Successfully";
    }
} ?>
        <form class="fullForm" method="post">
        <?php 
            $count_missing = count($errors['missing']??[]);
            $count_empty = count($errors['empty']??[]);
            if( $count_missing > 0): ?>
                <div class="error">
                    The field<?=$count_missing > 1 ? 's': ''?> :
                <?php  foreach($errors['missing']??[] as $field): ?>
                    <?= $field ?> , 
                <?php endforeach; ?>
                <?= $count_missing > 1 ? 'are': 'is'?> missing. The form may have been altered. please contact the Administration.
                </div>
        <?php endif;
            if( $count_empty > 0): ?>
                <div class="error">
                    The field<?=$count_empty > 1 ? 's': ''?> :
                <?php  foreach($errors['empty']??[] as $field): ?>
                    <?= $field ?> , 
                <?php endforeach; ?>
                <?= $count_empty > 1 ? 'are': 'is'?> empty. please fill <?=$count_empty > 1 ? 'them' : 'it'?>.
                </div>
        <?php endif;
            $warn("Please enter a valid email",'email');
            Text::email('User\'s email', 'email', 'email',
                        placeholder:'Enter new user\'s email', value:$old['email'] ?? null);
            Text::text('User\'s name', 'name', 'name',
                        placeholder:'Enter new user\'s name', maxlength:255,
                        value:$old['name'] ?? null);
            Text::password('Password(DEMO ONLY)', 'password', 'password',
                        placeholder:'Enter a password');
            Text::text('User\'s address', 'address', 'address',
                        placeholder:'Enter new user\'s address', maxlength:255,
                        value:$old['address'] ?? null);
            Text::text('User\'s contact number', 'contact_no', 'contact_no',
                        '+94XXXXXXXXX or 0XXXXXXXXX', type:'tel', maxlength:12,
                        pattern:"(\+94\d{9})|\d{10}", value:$old['contact_no'] ?? null);
            Text::text('User\'s NIC', 'nic', 'nic', 'XXXX or XXXXV',required:false, maxlength:12,
                        pattern:"(\d{12})|(\d{10}(V|v))", value:$old['nic'] ?? null);

            // ? Maybe do this in controller
            $roles = [];
            foreach ($data['roles'] as $role) {
                $roles[$role['staff_type_id']] = $role['staff_type'];
            }
            Group::select('User Role', 'role', $roles, 'role', selected:$old['role'] ?? null);

            Other::submit('Add','add',value:'Add User');
        ?>
        </form>
    </div>
</div>