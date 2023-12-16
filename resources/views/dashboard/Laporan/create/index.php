<?php
require("../../../../../app/Http/Conrtoller/Controller.php");

// if (!isset($_SESSION['login'])) {
// 	header('Location: http://localhost/web-rpl/');
// 	exit;
// }

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

function getLastNL($mysqli)
{
    $result = $mysqli->query("SELECT MAX(nomor_laporan) AS max_nl FROM statements");
    $row = $result->fetch_assoc();
    $lastNl = $row['max_nl'];

    if ($lastNl !== null) {
        $numericPart = substr($lastNl, 8);
        $pos = strcspn($numericPart, '0123456789');
        $numericPrefix = substr($numericPart, 0, $pos);
        $numericSuffix = substr($numericPart, $pos);
        $newNumericSuffix = ($numericSuffix !== '') ? (int)$numericSuffix + 1 : 1;
        $result = 'Laporan-' . $numericPrefix . $newNumericSuffix;
    } else {
        // Jika tidak ada nomor laporan sebelumnya, mulai dari 1
        $result = 'Laporan-1';
    }

    return $result;
}
$nextNl = getLastNL($mysqli);
$jenisBatu = getDatas("SELECT * FROM stocks");

$transactionZeolite = getDatas('SELECT * FROM transactions WHERE jenis_batu = "Zeolite"');
$transactionBalok = getDatas('SELECT * FROM transactions WHERE jenis_batu = "Balok"');

$totalPendapatanZeolite = getDatas('SELECT SUM(total) AS total_semua FROM transactions WHERE jenis_batu = "Zeolite"')[0];
$totalPendapatanBalok = getDatas('SELECT SUM(total) AS total_semua FROM transactions WHERE jenis_batu = "Balok"')[0];

$totalTerjualZeolite = getDatas('SELECT SUM(jumlah) AS jumlah_batu FROM transactions WHERE jenis_batu = "Zeolite"')[0];
$totalTerjualBalok = getDatas('SELECT SUM(jumlah) AS jumlah_batu FROM transactions WHERE jenis_batu = "Balok"')[0];

if($_SERVER["REQUEST_METHOD"] === "POST") {
    if(createStatement() > 0) {
        echo "
            <script>
                alert('data berhasil ditambahkan ah crot');
                document.location.href = 'http://localhost/web-rpl/resources/views/dashboard/laporan'
            </script>
        ";
    } else {
        echo "
            <script>
                alert('data gagal ditambahkan ah crot');
                document.location.href = 'http://localhost/web-rpl/resources/views/dashboard/laporan'
            </script>
        ";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <a href="http://localhost/web-rpl/resources/views/dashboard/laporan/">Kembali</a>
    <form action="" method="post" class="w-full bg-cyan-500 h-screen flex flex-col justify-center items-center gap-5">
        <div>
            <label for="">No Laporan</label>
            <input type="text" name="nomor_laporan" value="<?= $nextNl ?>" readonly>
        </div>
        <div>
            <label for="">Tanggal Laporan</label>
            <input type="date" name="tanggal" value="<?= date("Y-m-d") ?>" readonly>
        </div>
        <div class="flex gap-5">
            <div class="border-2 p-5 border-black">
                <div>
                    <label for="">Jenis Batu</label>
                    <input type="text" name="jenis_batu_zeolite" value="Zeolite">
                </div>
                <div>
                    <label for="">Jumlah Batu Terjual</label>
                    <input type="text" name="batu_terjual_zeolite" value="<?= $totalTerjualZeolite['jumlah_batu'] ?>" readonly>
                </div>
                <div>
                    <label for="">Jumlah Transaksi</label>
                    <input type="text" name="jumlah_transaksi_zeolite" value="<?= count($transactionZeolite) ?>" readonly>
                </div>
                <div>
                    <label for="">Jumlah Pendapatan</label>
                    <input type="text" name="jumlah_pendapatan_zeolite" value="<?= $totalPendapatanZeolite['total_semua'] ?>" readonly>
                </div>
            </div>
            <!-- Def -->
            <div class="border-2 p-5 border-black">
                <div>
                    <label for="">Jenis Batu</label>
                    <input type="text" name="jenis_batu_balok" value="Balok">
                </div>
                <div>
                    <label for="">Jumlah Batu Terjual</label>
                    <input type="text"  name="batu_terjual_balok" value="<?= $totalTerjualBalok['jumlah_batu'] ?>" readonly>
                </div>
                <div>
                    <label for="">Jumlah Transaksi</label>
                    <input type="text" name="jumlah_transaksi_balok" value="<?= count($transactionBalok) ?>" readonly>
                </div>
                <div>
                    <label for="">Jumlah Pendapatan</label>
                    <input type="text" name="jumlah_pendapatan_balok" value="<?= $totalPendapatanBalok['total_semua'] ?>" readonly>
                </div>
            </div>
        </div>
        <div>
            <button>Buat Laporan</button>
        </div>
    </form>
</body>

</html>