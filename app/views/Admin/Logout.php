<div class="content">
  <div class="logout">
    <select class="user-select" onchange="if(this.value=='Logout')location.href='<?= URLROOT . '/Login/Logout' ?>'">
      <Option style="display: none;">
        <?= $_SESSION['name'] ?>
      </Option>
      <Option value="Logout">
        Logout
      </Option>
    </select>
    <img src="<?= URLROOT . '/public/assets/Login.png' ?>" style="float:right;margin-right:.5rem;" height=30px alt="login-avatar">
  </div>