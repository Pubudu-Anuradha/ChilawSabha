<div class="content">
<?php
$staff = $data['staff']['result'][0] ?? null;
$errors = $data['errors'] ?? false;
if(!is_null($staff)): ?>
    <h1>
        Edit Staff User
    </h1>
    <hr>
    <div class="formContainer">
        <?php if(isset($data['Edit'])):
                if(!$data['Edit']['user']['success']):
                    $message = "Failed to Edit user " . $data['Edit']['user']['errmsg'];
                    Errors::generic($message);
                else: ?>
                <div class="success">
                    Changes saved Successfully!
                </div>
            <?php endif;
            endif;
        ?>
        <form class="fullForm" method="post">
        <?php Errors::validation_errors($errors,[
                'email' => "Email",
                'name' => 'Name',
                'address' => 'Address',
                'contact_no' => 'Contact number',
            ]); 

            Text::email('Email', 'email', 'email',
                        placeholder:'Enter new email',
                        value:$staff['email'] ?? null);
            Text::text('Name', 'name', 'name',
                        placeholder:'Enter user\'s new name', maxlength:255,
                        value:$staff['name'] ?? null);
            Text::text('Address', 'address', 'address',
                        placeholder:'Enter user\'s new address', maxlength:255,
                        value:$staff['address'] ?? null);
            Text::text('Contact number', 'contact_no', 'contact_no',
                        '+94XXXXXXXXX or 0XXXXXXXXX', type:'tel', maxlength:12,
                        pattern:"(\+94\d{9})|0\d{9}", value:$staff['contact_no'] ?? null);
            Other::submit('Edit','Edit',value:'Save Changes'); ?>
        </form>

        <?php
        $edit_history = $data['edit_history'] ?? false;
        if($edit_history !== false && count($edit_history) !== 0): ?>
        <h2>Edit History</h2>
        <hr>
<?php       $post = $staff;
            $fields = [
                'email' => "Email",
                'name' => 'Name',
                'address' => 'Address',
                'contact_no' => 'Contact number',
            ]; 
            foreach($edit_history as $edit): 
                foreach($fields as $field => $name):
                    if($edit[$field] !== null && $edit[$field] !== $post[$field]): ?>
                    <div class="record">
                        on <span class="time"> <?= $edit['time'] ?> </span> :
                        <?= $edit['changed_by'] ?> changed the field <b><?= $name ?></b> from 
                        "<?= $edit[$field] ?>" to "<?=$post[$field]?>".
                    </div>
                        <?php $post[$field] = $edit[$field];
                    endif;
                endforeach;
            endforeach;
        endif;
        ?>
    </div>
<?php else:?>
    ERROR retrieving user information
<?php endif;?>
</div>
<script>
    expandSideBar('sub-items-user');
</script>