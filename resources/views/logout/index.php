<?php
session_start();
if(!isset($_SESSION["login"])) {
    header("Location: http://localhost/web-rpl/");
}
$_SESSION = [];
session_unset();
session_destroy();
setcookie("id", "");
setcookie("key", "");
header("Location: http://localhost/web-rpl/");