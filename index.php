<?php
session_start();
require('./app/Http/Conrtoller/Controller.php');
$user = getDatas("SELECT * FROM users")[0];

if (isset($_COOKIE["id"]) && isset($_COOKIE["key"])) {
  $id = $_COOKIE["id"];
  $key = $_COOKIE["key"];
  if ($key === hash("sha224", getDatas("SELECT * FROM user WHERE id = '$id'")[0]["email"])) {
      $_SESSION["login"] = true;
  }
}

if(isset($_SESSION["login"])) {
  header("Location: http://localhost/web-rpl/resources/views/dashboard/");
}

if(isset($_POST["login"])) {
  $email = $_POST["email"];
  $password = $_POST["password"];

  if ($user) {
    if(password_verify($password, $user["password"])) {
      $_SESSION["login"] = true;
      if(isset($_POST["remember"])){
        setcookie("id", $user["user_id"], time() + 30000);
        setcookie("key", hash("sha224", $user["email"], time() + 30000));
      }
      header("Location: http://localhost/web-rpl/resources/views/dashboard/");
    } else {
      header("Location: http://localhost/web-rpl/");
    }
  }
  exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="./src/css/login.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
  <title>Login</title>
</head>

<body>
  <section>
    <form action="" method="post">
      <div class="riyot">
        <div class="logo">
          <img src="./public/assets/image/logoPT.png" alt="" />
        </div>
        <div class="logcre">
          <h2>Login</h2>
        </div>
        <div class="form">
          <div class="user">
            <input type="email" name="email" id="email"  placeholder="Email" value=""/>
          </div>
          <div class="pas">
            <input type="password" name="password" id="password" placeholder="Password" value=""/>
          </div>
        </div>
        <div class="remfor">
          <div class="rimem">
            <input id="chek" type="checkbox" name="remember" id="remember"/>
            <label for="chek">Remember me</label>
          </div>
          <div class="forpas">
            <a href="#">Forgot my password</a>
          </div>
        </div>
        <div class="conti">
          <button type="submit" name="login">Login in now</button>
        </div>
      </div>
    </form>
  </section>
</body>

</html>