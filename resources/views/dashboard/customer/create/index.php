<?php
session_start();
require("../../../../../app/Http/Conrtoller/Controller.php");
if (!isset($_SESSION['login'])) {
	header('Location: http://localhost/web-rpl/');
	exit;
}
if (isset($_SESSION['auth'])) {
	$user = $_SESSION["auth"];
	$isAdmin = getDatas("SELECT
	admins.id AS admin_id,
	users.id AS user_id,
	users.name,
	users.email,
	users.email_verified_at,
	admins.no_telp AS admin_no_telp,
	admins.created_at AS admin_created_at,
	admins.updated_at AS admin_updated_at
	FROM
	admins
	JOIN
	users ON admins.user_id = {$user['id']}
	")[0];

	if (!$isAdmin) {
		header('Location: http://localhost/web-rpl/resources/views/beranda');
		exit;
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <h1>bbbb</h1>

</body>
</html>