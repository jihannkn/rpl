<?php 
session_start();
require("../../../../../app/Http/Conrtoller/Controller.php");

if (!isset($_SESSION['login'])) {
	header('Location: http://localhost/web-rpl/');
	exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bumipersada";
$mysqli = new mysqli($servername, $username, $password, $dbname);
if ($mysqli->connect_error) {
	die("Connection failed: " . $mysqli->connect_error);
}


if (isset($_SESSION['auth'])) {
	$user = $_SESSION["auth"];

	$stmt = $mysqli->prepare("SELECT
        admins.id AS admin_id,
        users.np AS user_np,
        users.name,
        users.email,
        admins.no_telp AS admin_no_telp,
        admins.created_at AS admin_created_at,
        admins.updated_at AS admin_updated_at
        FROM
        admins
        JOIN
        users ON admins.user_np = users.np
        WHERE users.np = ?
        LIMIT 1");

	$stmt->bind_param("s", $user['np']);
	$stmt->execute();
	$result = $stmt->get_result();
	$isAdmin = $result->fetch_assoc();

	$stmt->close();

	if (!$isAdmin) {
		header('Location: http://localhost/web-rpl/resources/views/beranda');
		exit;
	}
}

$np = $_GET["np"];
if(deleteCustomer($np) > 0) {
    header("Location: http://localhost/web-rpl/resources/views/dashboard/customer/");
} else {
    echo "
    <script>
        alert('Data Gagal Dihapus Ah CROT!!!')
    document.location.href = 'http://localhost/web-rpl/resources/views/dashboard/customer/'
    </script>
    ";
}