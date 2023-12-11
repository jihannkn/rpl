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

$id = $_GET["id"];

if(deleteCustomer($id) > 0) {
    header("Location: http://localhost/web-rpl/resources/views/dashboard/customer/");
} else {
    echo "
    <script>
    alert('Data Gagal Dihapus Ah CROT!!!')
    document.location.href = 'http://localhost/web-rpl/resources/views/dashboard/customer/'
    </script>
    ";
}