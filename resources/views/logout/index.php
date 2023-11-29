<?php
session_start();
if(isset($_SESSION["login"])) {
    header("Location: ");
}
$_SESSION = [];
session_unset();
session_destroy();
setcookie("id", "");
setcookie("key", "");
header("Location: localhost/web-rpl");