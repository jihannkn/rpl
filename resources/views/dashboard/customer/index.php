<?php
session_start();
require("../../../../app/Http/Conrtoller/Controller.php");
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


$customers = getDatas("SELECT
users.np,
users.name,
users.email,
customers.alamat,
customers.no_telp AS customer_no_telp,
customers.created_at AS customer_created_at,
customers.updated_at AS customer_updated_at
FROM
users
JOIN
customers ON users.np = customers.user_np;
");
?>
<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
	<meta name="generator" content="Hugo 0.88.1">
	<title>Dashboard</title>
	<!-- Custom styles for this template -->
	<link href="../dashboard.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>

	<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
		<a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="http://localhost/web-rpl/resources/views/beranda">Bumi Indah Persada</a>
		<button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="navbar-nav">
			<div class="nav-item text-nowrap">
				<a class="nav-link px-3" href="http://localhost/web-rpl/resources/views/logout/">Sign out</a>
			</div>
		</div>
	</header>

	<div class="container-fluid">
		<div class="row">
			<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
				<div class="position-sticky pt-3">
					<ul class="nav flex-column">
						<li class="nav-item">
							<a class="nav-link" aria-current="page" href="http://localhost/web-rpl/resources/views/dashboard/">
								<span data-feather="home"></span>
								Dashboard
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link active" aria-current="page" href="http://localhost/web-rpl/resources/views/dashboard/customer/">
								<span data-feather="home"></span>
								Customer
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" aria-current="page" href="http://localhost/web-rpl/resources/views/dashboard/transaksi/">
								<span data-feather="home"></span>
								Transaksi
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" aria-current="page" href="http://localhost/web-rpl/resources/views/dashboard/laporan/">
								<span data-feather="home"></span>
								Laporan
							</a>
						</li>
					</ul>
				</div>
			</nav>

			<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
				<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
					<h1 class="h2">Customer</h1>
					<a href="http://localhost/web-rpl/resources/views/dashboard/customer/create" class="btn btn-primary btn-md">Tambah Data Customer</a>
				</div>
				<div class="table-responsive">
					<table class="table table-striped table-md ">
						<thead>
							<tr>
								<th scope="col">No</th>
								<th scope="col">Nama Perusahaan</th>
								<th scope="col">Action</th>
							</tr>
						</thead>
						<tbody class="">
							<?php foreach ($customers as $key => $customer) : ?>
								<tr>
									<td><?= $key + 1  ?></td>
									<td><?= $customer["name"]  ?></td>
									<td>
										<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#staticBackdrop<?= $customer["np"] ?>">
											Detail
										</button>
										<button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#staticBackdropDelete<?= $customer["np"] ?>">
											Delete
										</button>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
					<!-- Modal Detail -->
					<?php foreach ($customers as $key => $customer) : ?>
						<div class="modal fade" id="staticBackdrop<?= $customer["np"] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h1 class="modal-title fs-5" id="staticBackdropLabel">Detail Perusahaan</h1>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
									</div>
									<div class="modal-body">
										<div>
											<span>Nama PT : <?= $customer["name"] ?></span>
										</div>
										<div>
											<span>Email PT : <?= $customer["email"] ?></span>
										</div>
										<div>
											<span>Alamat PT : <?= $customer["alamat"] ?></span>
										</div>
										<div>
											<span>No Telephone PT : <?= $customer["customer_no_telp"] ?></span>
										</div>
									</div>
									<div class="modal-footer">
										<a href="http://localhost/web-rpl/resources/views/dashboard/customer/update?np=<?= $customer["np"] ?>" type="button" class="btn btn-info text-white">Update</a>
										<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
									</div>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
					<!-- Close Modal Detail -->
					<!-- Delete PUP -->
					<?php foreach ($customers as $key => $customer) : ?>
						<div class="modal fade" id="staticBackdropDelete<?= $customer["np"] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h1 class="modal-title fs-5" id="staticBackdropLabel">Detail Perusahaan</h1>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
									</div>
									<div class="modal-body">
										<span>Yakin dek dihapus ?</span>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
										<a href="http://localhost/web-rpl/resources/views/dashboard/customer/delete?id=<?= $customer["np"] ?>" type="button" class="btn btn-danger text-white">Delete</a>
									</div>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
					<!-- Close Delete PUP -->
				</div>
			</main>
		</div>
	</div>
	<!-- Js -->
	<script src="../dashboard.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>