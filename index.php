<?php
require('./app/Http/Conrtoller/Controller.php');
$user = dataStore("SELECT * FROM users")[0];

if(isset($_POST["login"])) {
  $email = $_POST["email"];
  $password = $_POST["password"];

  if ($user) {
    if($password == $user["password"]) {
      header("Location: http://localhost/web-rpl/resources/views/dashboard/");
    } else {
      header("Location: http://localhost/web-rpl/");
    }
  }
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
            <input type="email" name="email" id="email"  placeholder="Username" value=""/>
          </div>
          <div class="pas">
            <input type="password" name="password" id="password" placeholder="Password" value=""/>
          </div>
        </div>
        <div class="remfor">
          <div class="rimem">
            <input id="chek" type="checkbox" />
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