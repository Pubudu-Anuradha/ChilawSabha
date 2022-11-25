<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Library Staff Login</title>
    <link rel="stylesheet" href="<?=URLROOT . '/public/css/hasalaLogin.css'?>" />
  </head>
  <body>
    <header>
        <div class="upper-header">
          <ul>
            <li>
              <img src="<?=URLROOT . '/public/assets/Logo.jpg'?>" alt="Logo" class="logo-img" />
            </li>
            <li class="title">
              <h1 class="chilaw">
              CHILAW</h1>
              <span class="sabha">PRADESHIYA SABHA</span>

            </li>
          </ul>
        </div>

        <div class="lower-header">
            <a href="#" class="items">Services</a>
            <a href="#" class="items">Projects</a>
            <a href="#" class="items">Events</a>
            <a href="#" class="items">Announcements</a>
            <a href="#" class="items">Contact Us</a>
        </div>
    </header>

    <div class="login">
    <img src="<?=URLROOT . '/public/assets/Login.png'?>" alt="User" class="login-img" />
        <h1 class="login-title">LIBRARY STAFF LOGIN</h1>
        <div class="form">
          <form action="<?=URLROOT . '/Login/LibraryStaff'?>" method="post" class="form">
            <label for="email">Email</label>
            <input type="text" name="email" required class="email" /><br />
            <label for="password">Password</label>
            <input type="password" name="password" required class="password"/><br />
            <a href="#" class="forgotpw">Forgot your password?</a>

            <input type="submit" value="Login" name="login" id="login" />

          </form>
        </div>
</div>

<Footer>
    <h4 class="footer-content">Copyright © 2022</h4>
</Footer>

</body>

</html>