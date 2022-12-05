    <div class="logout">
        <select class="user-select" onchange="if(this.value=='Logout') location.href='<?=URLROOT . '/Login/Logout'?>'">
        <Option class="user-name">
            <?=$_SESSION['name']?>
        </Option>
        <Option value="Logout" class="logout-option">
            Logout
        </Option>
        </select>
        <img src="<?=URLROOT . '/public/assets/Login.png'?>" alt="login-avatar" class="logout-img">
    </div>