<div class="content">
    <h1>
<?php
$user = $data['enable']['result'][0] ?? false;
// var_dump($user);
if($user == false) {
  echo "Invalid action.";
}else{
  echo "Re-Enabling user " . $user['name'] . '(' . $user['email'] . ')';
}
?>
    </h1>
    <hr>
    <form class="fullForm" method="post">
    <?php
    Text::text('Please enter the reason<br />for Re-enabling this user','re_enabled_reason','reason','Type here',maxlength:255,spellcheck:true);

    Other::submit('confirm',value:'Confirm Re-Enabling user');
    ?>
    </form>
</div>
