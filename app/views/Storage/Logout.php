<img src="<?= URLROOT . '/public/assets/user.png' ?>" alt="Profile Avatar" class="profileAvatar" />
                            
<select class="logoutForm" name="logoutForm" id="logoutForm" onchange="if(this.value=='Logout')location.href='<?= URLROOT . '/Login/Logout' ?>'">
    <option value="name" style="display:none"><?= $_SESSION['name'] ?></option>
    <option value="Logout">Logout</option>
</select>