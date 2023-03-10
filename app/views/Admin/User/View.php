<div class="content">
<?php
// echo "<pre>";
// var_dump($data);
// echo "</pre>";
$id = $data['user_id'];
$staff = $data['user'];
$edit_history = $data['edit_history'] ?? false;
$state_history = $data['state_history'] ?? false;
$post = $staff;
$fields = [
    'email' => "Email",
    'name' => 'Name',
    'address' => 'Address',
    'contact_no' => 'Contact number',
];
if($staff!==false):
?>
<div class="card-container">
<div class="card">
    <h1>User Details</h1>
    <hr>
    <div class="user-details">
        <div class="detail">
            <span class="name"> Name </span>
            <span> <?= $staff['name'] ?? 'NO NAME ERROR' ?> </span>
        </div>
        <div class="detail">
            <span class="email"> Email </span>
            <span>
                <a href="mailto:<?=$staff['email']??'#'?>">
                    <?= $staff['email'] ?? 'NO EMAIL ERROR' ?>
                </a>
            </span>
        </div>
        <div class="detail">
            <span class="contact"> Contact Number </span>
            <span> <?= $staff['contact_no'] ?? 'NO CONTACT ERROR' ?> </span>
        </div>
        <div class="detail">
            <span class="address"> Address </span>
            <span> <?= $staff['address'] ?? 'NO ADDRESS ERROR' ?> </span>
        </div>
        <div class="detail">
            <span class="nic"> NIC number </span>
            <span> <?= $staff['nic'] ?? 'NO NIC ERROR' ?> </span>
        </div>
        <div class="detail">
            <span class="role"> User Role </span>
            <span> <?= $staff['role'] ?? 'ROLE UNDEFINED ERROR' ?> </span>
        </div>
        <div class="detail">
            <span class="state"> Current State </span>
            <span class="<?= ($staff['state'] ?? 'Disabled') ?>"> <?= $staff['state'] ?? 'UNKNOWN STATE ERROR' ?> </span>
        </div>
        <div class="options">
            <a href="<?=URLROOT . '/Admin/Users/Edit/' . ($id ?? '') ?>" class="btn edit bg-yellow">
              Edit
            </a>
            <?php switch($staff['state'] ?? false) {
              case 'Active': ?>
                  <a href="<?=URLROOT . '/Admin/Users/Disable/' . ($id ?? '') ?>" class="btn delist bg-red">
                    Disable
                  </a> <?php
                  break;
              case 'Disabled': ?>
                  <a href="<?=URLROOT . '/Admin/Users/Enable/' . ($id ?? '') ?>" class="btn enable bg-green">
                    Enable
                  </a>
              <?php break;
            } ?>
        </div>
    </div>
</div>
    <?php
    if($edit_history !== false && count($edit_history) !== 0): ?>
        <div class="edit-history card">
            <h2>User Details Edit History</h2>
            <hr>
    <?php
        $i = 0;
        foreach($edit_history as $edit): 
            foreach($fields as $field => $name):
                if($edit[$field] !== null && $edit[$field] !== $post[$field]): ?>
                <div class="record b<?= ($i++%2==1) ? '-alt':'' ?>">
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
    <?php
    if($state_history !== false && count($state_history) !== 0): ?>
        <div class="state-history card">
            <h2>User's State Change History</h2>
            <hr>
    <?php
        $i = 0;
        foreach($state_history as $state_change): ?>
          <?php if(!is_null($state_change['r_reason'])): ?>
            <div class="record<?= ($i++%2==0) ? ' b':''?>">
              on <span class="time">
                  <?= $state_change['r_time'] ?? 'NO TIMESTAMP ERROR' ?>
              </span> :
                <?= $state_change['r_name'] ?? 'No RE-ENABLER ERROR' ?>
                 Re-enabled this user citing the reason 
                 "<b><?= $state_change['r_reason'] ?? 'No reason ERROR' ?></b>". 
            </div>
          <?php endif; ?>
            <div class="record<?= ($i++%2==0) ? ' b':'' ?>">
              on <span class="time">
                  <?= $state_change['d_time'] ?? 'NO TIMESTAMP ERROR' ?>
              </span> :
                <?= $state_change['d_name'] ?? 'No DISABLER ERROR' ?>
                 Disabled this user citing the reason 
                 "<b><?= $state_change['d_reason'] ?? 'No reason ERROR' ?></b>". 
            </div>
    <?php
        endforeach;
    endif;
    ?>
        </div>
    </div>
<?php else: ?>
<h1>
  USER NOT FOUND
</h1>
<?php endif; ?>
</div>

<script>
    expandSideBar('sub-items-user');
</script>