<div class="login-form">
    <div class="login-form-content">
        <div class="login-title">
            <img src="<?= URLROOT . '/public/assets/user.png' ?>" class="login-img" alt="Login img">
            <h1>USER LOGIN</h1>
        </div>
        <form action="<?= URLROOT . "/Login/index" ?>" method="post" class="login-field">
            <div class="field">
                <label for="email">Email</label>
                <input type="email" name="email" id="email">
            </div>
            <div class="field">
                <label for="passwd">Password</label>
                <input type="password" name="passwd" id="passwd">
            </div>
            <div class="field">
                <a href="<?=URLROOT . '/Login/passwordReset' ?>">Forgot your password?</a>
                <input type="submit" name="Submit" value="Login" class="submit-btn">
            </div>
        </form>
    </div>
</div>
