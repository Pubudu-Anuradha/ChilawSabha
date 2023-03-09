<div class="content">
<?php
echo "<pre>";
var_dump($data);
echo "</pre>";
$staff = $data['user'];
$edit_history = $data['edit_history'] ?? false;
$post = $staff;
$fields = [
    'email' => "Email",
    'name' => 'Name',
    'address' => 'Address',
    'contact_no' => 'Contact number',
    'nic' => 'NIC Number',
    'role' => 'User\'s role',
]; ?> 
    <div class="histories">
    <?php
    if($edit_history !== false && count($edit_history) !== 0): ?>
        <div class="edit-history">
            <h2>Edit History</h2>
            <hr>
    <?php
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
    </div>
 </div>