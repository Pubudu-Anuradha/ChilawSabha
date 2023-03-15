<div class="content">
    <h1>
<?php
$user = $data['disabled']['result'][0] ?? false;
// var_dump($user);
if($user == false) {
  echo "Invalid action.";
}else{
  echo "Disabling user " . $user['name'] . '(' . $user['email'] . ')';
}
?>
    </h1>
    <hr>
    <form class="fullForm" method="post">
    <?php
    Text::text('Please enter the reason<br />for disabling this user','disable_reason','reason','Type here',maxlength:255,spellcheck:true);

    Other::submit('confirm',value:'Confirm disabling user');
    ?>
    </form>
</div>
