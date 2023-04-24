<?php
$old    = $data['old']    ?? false;
$errors = $data['errors'] ?? false;

$warn = function($message,$err_name,$_field = false) use(&$errors) {
    if($err_name == 'empty' || $err_name == 'missing'){
        if(array_search($_field,$errors[$err_name]??[])!==false){ ?>
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
<div class="login-form">
    <div class="login-form-content">
        <div class="login-title">
            <img src="<?= URLROOT . '/public/assets/user.png' ?>" class="login-img" alt="Login img">
            <h1>USER LOGIN</h1>
        </div>
        <form action="<?= URLROOT . "/Login" ?>" method="post" class="login-field">

            <?php
                $warn("There was an error while handling your login attempt. <br /> Please try again. <br /> If the issue persists, please contact the website administration.",
                    'login error');
                $warn("It seems your connection with the site has been tampered with. <br />
                      Please contact the website administration.",'extras?');
                $warn("Please enter an email",'missing','email');
                $warn("Please enter an email",'empty','email');
                $warn("Please enter a valid email",'email');
                $warn("There is no registered user with that email",'no email');
                $warn("That user has been disabled",'disabled');
                $warn("We unfortunately do not support the use of emails longer than 255 characters",
                    'max_len','email');

                    
                $msg = NULL;
                if(!empty($data['change-success'])){
                    $msg = $data['change-success'];
            ?>
                    <span class="success-msg" style="display: flex; justify-content: center">
                        <?= $msg ?>
                    </span>
            <?php
                }
            ?>
            <div class="field">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" maxlength="255" 
                    <?= $old && $old['email'] ? 'value="' .$old['email'] . '"':'' ?>
                > 
            </div>
            <?php 
                $warn("Please enter your password",'missing','passwd');
                $warn("Incorrect Password",'password match');
            ?>
            <div class="field">
                <label for="passwd">Password</label>
                <input type="password" name="passwd" id="passwd" 
                    <?= $old && $old['passwd'] ? 'value="' .$old['passwd'] . '"':'' ?>
                required>
            </div>
            <div class="field">
                <a href="<?=URLROOT . '/Login/passwordReset' ?>">Forgot your password?</a>
                <input type="submit" name="Login" value="Login" class="submit-btn">
            </div>
        </form>
    </div>
</div>
