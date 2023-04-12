<div class="password-reset-form">
    <div class="password-reset-form-content">
        <div class="pw-reset-title">
            <img src="<?= URLROOT . '/public/assets/forgot-password.png' ?>" class="pw-reset-img" alt="Pw reset img">
            <h1>FORGOT PASSWORD</h1>
            <?php
                $otherErr = '';
                if(!empty($data['change-error'])){
                    $otherErr = $data['change-error'];
                }else if(!empty($data['submit-err'])){
                    $otherErr = $data['submit-err'];
                }else if(!empty($data['reset-auth-err'])){
                    $otherErr = $data['reset-auth-err'];
                }else if(!empty($data['code-time-limit'])){
                    $otherErr = $data['code-time-limit'];}
                if(!empty($otherErr)){
            ?>
                    <span class="err-msg">
                        <?= $otherErr ?>
                    </span>
            <?php
                }
            ?>
        </div>
        <form action="<?= URLROOT . "/Login/passwordReset" ?>" method="post" class="pw-reset-field" autocomplete=false onsubmit="return validateForm()">
            
            <?php 
                $value = !empty($data['mail']) ? $data['mail'] : NULL;
                $mailError = '';
                if(!empty($data['no-email'])){
                    $mailError = $data['no-email'];
                }else if(!empty($data['no-user'])){
                    $mailError = $data['no-user'];
                }else if(!empty($data['reset-err'])){
                    $mailError = $data['reset-err'];
                }
                
                echo Text::email('Email', 'forgot-email', 'forgot-email-id', NULL, false, $value, 'Enter your Email', NULL,NULL, false, empty($mailError) ? NULL : $mailError);
            ?>
            
            <div class="input-field">

                <label for="reset-code">Reset Code</label>    
                <div class="reset-input-field">
                    <?php
                        $msg = NULL;
                        if(!empty($data['mail-success'])){
                            $msg = $data['mail-success'];
                    ?>
                            <span class="success-msg">
                                <?= $msg ?>
                            </span>
                    <?php
                        }else {
                            $codeErr = '';
                            if(!empty($data['no-code'])){
                                $codeErr = $data['no-code'];
                            }else if(!empty($data['reset-code-err'])){
                                $codeErr = $data['reset-code-err'];
                            }else if(!empty($data['reset-mail-unmatch'])){
                                $codeErr = $data['reset-mail-unmatch'];
                            }else if(!empty($data['reset-time-err'])){
                                $codeErr = $data['reset-time-err'];
                            }
                            if(!empty($codeErr)){
                    ?>
                                <span class="err-msg">
                                    <?= $codeErr ?>
                                </span>
                    <?php
                            }
                        }
                        $code = !empty($data['resetCode']) ? $data['resetCode'] : NULL;
                    ?>
                    
                    <input type="text" name="reset-code-text" id="reset-code" placeholder="Enter reset code" pattern="^[0-9]{1,6}$" value="<?= $code ?>" >
                    <?php
                        if(empty($data['mail-success']) && !$data['auth-status']){
                            echo '<input type="submit" name="resetCode" value="Send Code" id="reset-code-btn">';
                        }else if(!empty($data['mail-success']) && !$data['auth-status']){
                            echo '<input type="submit" name="enterCode" value="Authenticate" id="authenticate-code">';
                        }else if($data['auth-status']){
                            echo '<input type="submit" name="authenticated" value="Authenticated" id="authenticated-code" disabled>';
                        } 
                    ?>
                </div>
            </div>
            <?php 
                $passError = '';
                if(!empty($data['no-new-password'])){
                    $passError = $data['no-new-password'];
                }else if(!empty($data['password-unmatch'])){
                    $passError = $data['password-unmatch'];
                }
                echo Text::password('Password', 'new-password', 'new-password-id', NULL, NULL,'Enter your new password', `^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$`,false,!$data['auth-status'] ? true : false, empty($passError) ? NULL : $passError);

                $confError = '';
                if(!empty($data['no-confirm-password'])){
                    $confError = $data['no-confirm-password'];
                }
                echo Text::password('Confirm Password', 'confirm-password', 'confirm-password-id', NULL, NULL,'Confirm your new password', `^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$`,false,!$data['auth-status'] ? true : false, empty($confError) ? NULL : $confError);

                echo Other::submit('Submit', 'submit-btn-id', NULL, 'Submit',!$data['auth-status'] ? true : false);
            ?>
        </form>
    </div>
</div>

<script>
    function validateForm(){
        var email = document.getElementById('forgot-email-id').value;
        var resetCode = document.getElementById('reset-code').value;
        var newPassword = document.getElementById('new-password-id').value;
        var confirmPassword = document.getElementById('confirm-password-id').value;

        if(document.getElementById('reset-code-btn')){
            if(email == '' || email == null){
                alert('Email is required');
                return false;
            }
        }else if(document.getElementById('authenticate-code') || document.getElementById('authenticated-code')){
            if(email == '' || email == null){
                alert('Email is required');
                return false;
            }
            if(resetCode == '' || resetCode == null){
                alert('Reset code is required');
                return false;
            }else if(resetCode.length < 6){
                alert('Reset code must be 6 digits');
                return false;
            }
        }
        var submit = document.getElementById('submit-btn-id');

        document.addEventListener('click', ()=>{
            if(document.getElementById('authenticated-code')){
                if(email == '' || email == null){
                    alert('Email is required');
                    return false;
                }
                if(resetCode == '' || resetCode == null){
                    alert('Reset code is required');
                    return false;
                }else if(resetCode.length < 6){
                    alert('Reset code must be 6 digits');
                    return false;
                }
                if(newPassword == '' || newPassword == null){
                    alert('New password is required');
                    return false;
                }else if(confirmPassword == '' || confirmPassword == null){
                    alert('Confirm password is required');
                    return false;
                }else if(newPassword.length < 8){
                    alert('Password must be at least 8 characters');
                    return false;
                }else if(newPassword != confirmPassword){
                    alert('Password does not match');
                    return false;
                }
            }else{
                alert('Please authenticate your email first');
                return false;
            }
        });
    }
</script>
