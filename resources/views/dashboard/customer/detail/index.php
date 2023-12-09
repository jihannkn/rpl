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
$customer_id = $_GET["id"];
$customer = getDatas("SELECT
users.id,
users.name,
users.email,
users.email_verified_at,
customers.alamat,
customers.no_telp AS customer_no_telp,
customers.created_at AS customer_created_at,
customers.updated_at AS customer_updated_at
FROM
users
JOIN
customers ON users.id = '$customer_id';
")[0];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
    <a href="http://localhost/web-rpl/resources/views/dashboard/customer/">Kembali</a>
    <form>
        <div>
            <label for="">Nama PT</label>
            <input type="text" value="<?= $customer["name"] ?>">
        </div>
        <div>
            <label for="">Email PT</label>
            <input type="email" value="<?= $customer["email"] ?>">
        </div>
        <div>
            <label for="">Alamat PT</label>
            <input type="text" value="<?= $customer["alamat"] ?>">
        </div>
        <div>
            <label for="">No Telp PT</label>
            <input type="text" value="<?= $customer["customer_no_telp"] ?>">
        </div>
        <button class="btn btn-primary btn-md">update</button>
    </form>
    	<!-- Js -->
	<script src="../dashboard.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>