<div class="password-reset-form">
    <div class="password-reset-form-content">
        <div class="pw-reset-title">
            <img src="<?= URLROOT . '/public/assets/forgot-password.png' ?>" class="pw-reset-img" alt="Pw reset img">
            <h1>FORGOT PASSWORD</h1>
        </div>
        <form action="<?= URLROOT . "/Login/passwordReset" ?>" method="post" class="pw-reset-field" autocomplete=false>
            
            <?php 
                $value = !empty($data['mail']) ? $data['mail'] : NULL;
                
                echo Text::email('Email', 'forgot-email', 'forgot-email-id', NULL, false, $value, 'Enter your Email', `([-!#-'*+/-9=?A-Z^-~]+(\.[-!#-'*+/-9=?A-Z^-~]+)*|\"([]!#-[^-~ \t]|(\\[\t -~]))+\")@([0-9A-Za-z]([0-9A-Za-z-]{0,61}[0-9A-Za-z])?(\.[0-9A-Za-z]([0-9A-Za-z-]{0,61}[0-9A-Za-z])?)*|\[((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9]?[0-9])(\.(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9]?[0-9])){3}|IPv6:((((0|[1-9A-Fa-f][0-9A-Fa-f]{0,3}):){6}|::((0|[1-9A-Fa-f][0-9A-Fa-f]{0,3}):){5}|[0-9A-Fa-f]{0,4}::((0|[1-9A-Fa-f][0-9A-Fa-f]{0,3}):){4}|(((0|[1-9A-Fa-f][0-9A-Fa-f]{0,3}):)?(0|[1-9A-Fa-f][0-9A-Fa-f]{0,3}))?::((0|[1-9A-Fa-f][0-9A-Fa-f]{0,3}):){3}|(((0|[1-9A-Fa-f][0-9A-Fa-f]{0,3}):){0,2}(0|[1-9A-Fa-f][0-9A-Fa-f]{0,3}))?::((0|[1-9A-Fa-f][0-9A-Fa-f]{0,3}):){2}|(((0|[1-9A-Fa-f][0-9A-Fa-f]{0,3}):){0,3}(0|[1-9A-Fa-f][0-9A-Fa-f]{0,3}))?::(0|[1-9A-Fa-f][0-9A-Fa-f]{0,3}):|(((0|[1-9A-Fa-f][0-9A-Fa-f]{0,3}):){0,4}(0|[1-9A-Fa-f][0-9A-Fa-f]{0,3}))?::)((0|[1-9A-Fa-f][0-9A-Fa-f]{0,3}):(0|[1-9A-Fa-f][0-9A-Fa-f]{0,3})|(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9]?[0-9])(\.(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9]?[0-9])){3})|(((0|[1-9A-Fa-f][0-9A-Fa-f]{0,3}):){0,5}(0|[1-9A-Fa-f][0-9A-Fa-f]{0,3}))?::(0|[1-9A-Fa-f][0-9A-Fa-f]{0,3})|(((0|[1-9A-Fa-f][0-9A-Fa-f]{0,3}):){0,6}(0|[1-9A-Fa-f][0-9A-Fa-f]{0,3}))?::)|(?!IPv6:)[0-9A-Za-z-]*[0-9A-Za-z]:[!-Z^-~]+)])`,NULL, empty($data['noemail']) ? NULL : $data['noemail']);
            ?>
            
            <div class="input-field">

                <label for="reset-code">Reset Code</label>    
                <div class="reset-input-field">
                    <?php
                        $msg = NULL;
                        if(!empty($data['mailsuccess'])){
                            $msg = $data['mailsuccess'];
                    ?>
                            <span class="success-msg">
                                <?= $msg ?>
                            </span>
                    <?php
                        }
                        $code = !empty($data['resetCode']) ? $data['resetCode'] : NULL;
                    ?>
                    
                    <input type="text" name="reset-code-text" id="reset-code" placeholder="Enter reset code" pattern="^[0-9]{1,6}$" maxlength=6 minlength=6 value="<?= $code ?>"onChange=checkCode>
                    <?php
                        if(empty($data['mailsuccess']) && empty($data['authstatus'])){
                            echo '<input type="submit" name="resetCode" value="Send Code" id="reset-code-btn">';
                        }else if(!empty($data['authstatus'])){
                            echo '<input type="submit" name="authenticated" value="Authenticated" id="authenticated-code">';
                        }else{
                            echo '<input type="submit" name="enterCode" value="Authenticate" id="authenticate-code">';
                        } 
                    ?>
                </div>
            </div>
            <?php 
                //$validate_status = $data['validate_reset_code'] ? false : true; 
                echo Text::password('Password', 'new-password', 'new-password-id', NULL, NULL,'Enter your new password', `^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$`,false,empty($data['authstatus']) ? true : false);
                echo Text::password('Confirm Password', 'confirm-password', 'confirm-password-id', NULL, NULL,'Confirm your new password', `^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$`,false,empty($data['authstatus']) ? true : false);
                echo Other::submit('Submit', 'submit-btn-id', NULL, 'Submit',empty($data['authstatus']) ? true : false);
            ?>
        </form>
    </div>
</div>
