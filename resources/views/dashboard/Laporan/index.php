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

$statements = getDatas('SELECT * FROM statements');
?>

<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
	<meta name="generator" content="Hugo 0.88.1">
	<title>Dashboard - Laporan</title>
	<!-- Custom styles for this template -->
	<link href="../dashboard.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

	<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow d-print-none">
		<a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="http://localhost/web-rpl/resources/views/beranda">Bumi Indah Persada</a>
		<button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
		<div class="navbar-nav">
			<div class="nav-item text-nowrap">
				<a class="nav-link px-3" href="http://localhost/web-rpl/resources/views/logout/">Sign out</a>
			</div>
		</div>
	</header>

	<div class="container-fluid d-print-none">
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
							<a class="nav-link active" aria-current="page" href="http://localhost/web-rpl/resources/views/dashboard/laporan/">
								<span data-feather="home"></span>
								Laporan
							</a>
						</li>
					</ul>
				</div>
			</nav>

			<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
				<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
					<h1 class="h2">Laporan</h1>
					<a href="http://localhost/web-rpl/resources/views/dashboard/laporan/create" class="btn btn-primary btn-sm">Buat Laporan</a>
				</div>
				<div class="table-responsive">
					<table class="table table-striped table-sm">
						<thead>
							<tr>
								<th scope="col">No</th>
								<th scope="col">Tanggal Laporan</th>
								<th scope="col">Jenis Batu</th>
								<th scope="col">Jumlah Pembelian</th>
								<th scope="col">Total</th>
								<th scope="col">Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php if (count($statements) > 0) : ?>
								<?php foreach ($statements as $key => $value) : ?>
									<tr>
										<td><?= $key + 1 ?></td>
										<td><?= date('d-m-Y', strtotime($value["tanggal"])) ?></td>
										<td><?= $value["jenis_batu"] ?></td>
										<td><?= $value["jumlah_batu_terjual"] ?></td>
										<td><?= $value["jumlah_pendapatan"] ?></td>
										<td>
											<a href="http://localhost/web-rpl/resources/views/dashboard/laporan/cetak?nomor=<?=$value['nomor_laporan']?>" class="btn btn-sm btn-success"><i class="fa-solid fa-print"></i></a>
											<button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#staticBackdropDelete<?= $value["nomor_laporan"] ?>">
											<i class="fa-solid fa-trash"></i>
										</button>
										</td>
										
									</tr>
								<?php endforeach; ?>
							<?php else : ?>
								<tr>
									<td colspan="6" class="text-center fs-5 text-info p-4">Tidak Ada Laporan</td>
								</tr>
							<?php endif; ?>
						</tbody>
					</table>
				</div>
				<?php foreach ($statements as $key => $statement) : ?>
						<div class="modal fade" id="staticBackdropDelete<?= $statement["nomor_laporan"] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h1 class="modal-title fs-5" id="staticBackdropLabel">Detail Perusahaan</h1>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
									</div>
									<div class="modal-body">
										<span>Yakin dihapus?</span>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
										<a href="http://localhost/web-rpl/resources/views/dashboard/laporan/delete?nomor_laporan=<?= $statement["nomor_laporan"] ?>" type="button" class="btn btn-danger text-white">Delete</a>
									</div>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
			</main>
		</div>
	</div>
	<script src="../dashboard.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>