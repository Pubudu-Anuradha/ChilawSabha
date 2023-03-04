<?php
$errors = $data['errors'] ?? false;
$old    = $data['old']    ?? false;
function warn($message,$err_name,$_field = false){
    if((!$_field && ($errors[$err_name]??false)) ||
       ($_field && ($errors[$err_name][$_field]??false))
    ){ ?>
        <div class="error">
            <?=$message?>
        </div>
    <?php }
}
?>
<div class="login-form">
    <div class="login-form-content">
        <div class="login-title">
            <img src="<?= URLROOT . '/public/assets/user.png' ?>" class="login-img" alt="Login img">
            <h1>USER LOGIN</h1>
        </div>
        <form action="<?= URLROOT . "/Login/index" ?>" method="post" class="login-field">
            <?php if($errors && $errors['login error'] ?? false):?>
                <div class="error">
                    There was an error while handling your login attempt. <br />
                    Please try again. <br />
                    If the issue persists, please contact the website administration.
                </div>
            <?php endif; ?>
            <?php if($errors && $errors['extras?'] ?? false):?>
                <div class="error">
                    It seems your connection with the site has been tampered with. <br />
                    Please contact the website administration.
                </div>
            <?php endif; ?>
            <?php if($errors && $errors['missing']['email'] ?? false):?>
                <div class="error">
                    Please enter an email
                </div>
            <?php endif; ?>
            <?php if($errors && $errors['email']['email'] ?? false):?>
                <div class="error">
                    Please Enter a valid Email
                </div>
            <?php endif; ?>
            <?php if($errors && $errors['max_len']['email'] ?? false):?>
                <div class="error">
                    We unfortunately do not support the use of emails longer than 255 characters.
                </div>
            <?php endif; ?>
            <div class="field">
                <label for="email">Email</label>
                <input type="text" name="email" id="email" maxlength="255" 
                    <?= $old && $old['email'] ? 'value="' .$old['email'] . '"':'' ?>
                required>
            </div>
            <?php if($errors && $errors['missing']['passwd'] ?? false):?>
                <div class="error">
                    Please enter your password
                </div>
            <?php endif; ?>
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
