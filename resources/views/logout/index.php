<?php
session_start();
if(isset($_SESSION["login"])) {
    header("Location: ");
}
$_SESSION = [];
session_unset();
session_destroy();
header("Location: localhost/web-rpl");