<div class="content">
<?php

$id = $data['user_id'];
$users = $data['user'];
$edit_history = $data['edit_history'] ?? false;
$state_history = $data['state_history'] ?? false;
$enable_error = $data['enable_error'] ?? false;
$disable_error = $data['disable_error'] ?? false;
$post = $users;
$fields = [
    'email' => "Email",
    'name' => 'Name',
    'address' => 'Address',
    'contact_no' => 'Contact number',
];

if($users!==false):
?>
<div class="card-container">

<div class="card">
    <h1>User Details</h1>
    <hr>
    <div class="user-details">
        <div class="detail">
            <span class="name"> Name </span>
            <span> <?= $users['name'] ?? 'NO NAME ERROR' ?> </span>
        </div>
        <div class="detail">
            <span class="email"> Email </span>
            <span>
                <a href="mailto:<?=$users['email']??'#'?>">
                    <?= $users['email'] ?? 'NO EMAIL ERROR' ?>
                </a>
            </span>
        </div>
        <div class="detail">
            <span class="contact"> Contact Number </span>
            <span> <?= $users['contact_no'] ?? 'NO CONTACT ERROR' ?> </span>
        </div>
        <div class="detail">
            <span class="address"> Address </span>
            <span> <?= $users['address'] ?? 'NO ADDRESS ERROR' ?> </span>
        </div>

        <div class="detail">
            <span class="state"> Current State </span>
            <span class="<?= ($users['state'] ?? 'Disabled') ?>"> <?= $users['state'] ?? 'UNKNOWN STATE ERROR' ?> </span>
        </div>
        <form class="fullForm" method="post">
        <div class="options">
            <a href="<?=URLROOT . '/LibraryStaff/Editusers/' . ($id ?? '') ?>" class="btn edit bg-yellow">
              Edit
            </a>
                <?php switch($users['state'] ?? false) {
                case 'Active': ?>
                        <button onclick="openModal(<?=$id?>,'disable_description')" class="btn delist bg-red">
                            Disable
                        </button>
                        <?php Modal::Modal(textarea:true, title:"Reason For Disabling", name:'disable_description', id:'disable_description', rows:10, cols:50, required:true, textTitle:'Membership ID', textId:'disabled_member_ID');?>
                    <?php
                        break;
                case 'Disabled': ?>
                        <button onclick="openModal(<?=$id?>,'enable_description')" class="btn enable bg-green">
                            Enable
                        </button>
                        <?php Modal::Modal(textarea:true, title:"Reason For Enabling", name:'enable_description', id:'enable_description', rows:10, cols:50, required:true, textTitle:'Membership ID', textId:'enabled_member_ID');?>
                    <?php
                        break;
                } ?>
        </div>

        <?php if ($enable_error) {
            $message = "There was an error while enabling user";
            Errors::generic($message);
        }
        if ($disable_error) {
            $message = "There was an error while disabling user";
            Errors::generic($message);
        }
        ?>

        </form>
    </div>
</div>
    <?php
    if($edit_history !== false && count($edit_history) !== 0): ?>
        <div class="edit-history card">
            <h2>User Edit History</h2>
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
            <h2>User State Change History</h2>
            <hr>
    <?php
        $i = 0;
        foreach($state_history as $state_change): ?>
          <?php if(!is_null($state_change['r_reason'])): ?>
            <div class="record<?= ($i++%2==0) ? ' b':''?>">
              on <span class="time">
                  <?= $state_change['r_time'] ?? 'NO TIMESTAMP ERROR' ?>
              </span> :
                <?= $state_change['r_name'] ?? 'NO RE-ENABLER ERROR' ?>
                 Re-enabled this user citing the reason
                 "<b><?= $state_change['r_reason'] ?? 'NO REASON ERROR' ?></b>".
            </div>
          <?php endif; ?>
            <div class="record<?= ($i++%2==0) ? ' b':'' ?>">
              on <span class="time">
                  <?= $state_change['d_time'] ?? 'NO TIMESTAMP ERROR' ?>
              </span> :
                <?= $state_change['d_name'] ?? 'NO DISABLER ERROR' ?>
                 Disabled this user citing the reason
                 "<b><?= $state_change['d_reason'] ?? 'NO REASON ERROR' ?></b>".
            </div>
    <?php
        endforeach;
    endif;
    ?>
        </div>
</div>
<?php else: ?>
<h1>
  ERROR RETRIEVING LIBRARY MEMBER INFORMATION
</h1>
<?php endif; ?>
</div>

<script>
    expandSideBar("sub-items-user","see-more-usr");
    var openedModal;

    function closeModal(){
        openedModal.style.display = "none";
    }
    function openModal(id,modal){
        event.preventDefault();
        openedModal = document.getElementById(modal);
        openedModal.querySelector('input[type="number"]').value = id;
        openedModal.style.display = "block";

        window.onclick = function(event) {
            if (event.target == openedModal) {
                openedModal.style.display = "none";
            }
        }
    }

</script>
