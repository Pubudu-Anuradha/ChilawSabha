<div class="password-reset-form">
    <div class="password-reset-form-content">
        <div class="pw-reset-title">
            <img src="<?= URLROOT . '/public/assets/forgot-password.png' ?>" class="pw-reset-img" alt="Pw reset img">
            <h1>FORGOT PASSWORD</h1>
        </div>
        <form action="<?= URLROOT . "/Login/passwordReset" ?>" method="post" class="pw-reset-field">
            <div class="field">
                <label for="email">Email</label>
                <input type="email" name="email" id="email">
            </div>
            <div class="field">
                <div>
                    <label for="resetcode">Reset Code</label>    
                </div>
                <div class="reset-code-input">
                    <input type="text" name="resetCodeText" id="resetcode" class="reset-code-field">
                    <input type="submit" name="resetCode" value="Send Code" class="reset-code-btn">
                </div>
            </div>
            <div class="field">
                <label for="passwd">New Password</label>
                <input type="password" name="newpasswd" id="newpasswd">
            </div>
            <div class="field">
                <label for="passwd">Confirm Password</label>
                <input type="password" name="confirmpasswd" id="confirmpasswd">
            </div>
            <div class="field submit-field">
                <input type="submit" name="Submit" value="Confirm" class="submit-btn">
            </div>
        </form>
    </div>
</div>