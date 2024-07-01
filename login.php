<?php
include "config.php";
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- ======import icons css font======= -->
  <link rel="stylesheet" href="https://cdn.lineicons.com/4.0/lineicons.css">
  <link rel="stylesheet" href="src/css/style-login.css">
  <title>เข้าสู่ระบบ</title>
</head>

<body style="background-color: #a0a0a0">
  <div class="container" id="container">
    <div class="form-container user-container">
      <form action="back-end/login_db.php" method="post">
        <img src="src/img/cs.png" alt="" style="width:150px">
        <h2>Login</h2>
        <input id="username" type="text" name="email" placeholder="Username">
        <input type="password" name="password" placeholder="Password" id="password">
        <!-- <input class="hide" id="hide" type="checkbox" onclick="checkPW()"> -->
        <button type="submit" name="login_user">Login</button>
      </form>
    </div>

    <div class="overlay-container">
      <div class="overlay">
        <div class="overlay-panel overlay-left">
          <h2 class="title">ACAQPS</h2>
          <!-- <button class="ghost" id="user">Login
            <i class="lni lni-arrow-left user"></i>
          </button> -->
        </div>
        <!-- <div class="overlay-panel overlay-right">
          <h3 class="title">For Register</h3>
          <button class="ghost" id="register">Register
            <i class="lni lni-arrow-right register"></i>
          </button>
        </div> -->
      </div>
    </div>
  </div>
</body>

</html>