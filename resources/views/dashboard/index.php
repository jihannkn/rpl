<?php
session_start();
require('../../../app/Http/Conrtoller/Controller.php');
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
$stones = getDatas("SELECT * FROM stocks");
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
	<link href="dashboard.css" rel="stylesheet">
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
			<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
				<div class="position-sticky pt-3">
					<ul class="nav flex-column">
						<li class="nav-item">
							<a class="nav-link active" aria-current="page" href="http://localhost/web-rpl/resources/views/dashboard/">
								<span data-feather="home"></span>
								Dashboard
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" aria-current="page" href="http://localhost/web-rpl/resources/views/dashboard/customer/">
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
					<h1 class="h3">Dashboard</h1>
				</div>
				<div class="row">
					<?php foreach ($stones as $index => $stone) : ?>
						<div class="col-sm-6 mb-3 mb-sm-0">
							<div class="card">
								<div class="card-body">
									<h5 class="card-title">Jenis Batu : <?= $stone["jenis"] ?></h5>
									<p class="card-text">Jumlah Stock : <?= $stone["jumlah_stok"] ?> - TON</p>
									<a href="http://localhost/web-rpl/resources/views/dashboard/create?jenis=<?= $stone["jenis"] ?>" class="btn btn-primary">Tambah Stock</a>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</main>
		</div>
	</div>
	<!-- Js -->
	<script src="dashboard.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>