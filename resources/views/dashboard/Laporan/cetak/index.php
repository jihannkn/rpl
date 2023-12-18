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

$noLap = $_GET['nomor'];
$statements = getDatas("SELECT * FROM statements WHERE nomor_laporan = '$noLap'");
$total = getDatas("SELECT SUM(jumlah_pendapatan) AS total FROM statements")[0];

function bulanIndonesia($angkaBulan) {
    $daftarBulan = [
        1 => 'Januarianto',
        2 => 'Februarikriting',
        3 => 'Maretono',
        4 => 'Aprilianadewiputri',
        5 => 'Mei-Mei Susanti',
        6 => 'Juniadi',
        7 => 'Juliyantoro',
        8 => 'Agustus',
        9 => 'Septemberasasusu',
        10 => 'Oktobersamadia',
        11 => 'Novemberentoentod',
        12 => 'Desemberanakapinak',
    ];

    return $daftarBulan[$angkaBulan];
}
$tanggal = $statements[0]['tanggal'];
$angkaBulan = date('n', strtotime($tanggal));

?>
<!DOCTYPE html>
<html>

<head>
    <title>Laporan Bulanan</title>
    <style>
        /* Styles untuk laporan */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            padding: 10px;
        }

        .kop {
            font-weight: bold;
            text-align: center;
        }

        .alamat {
            text-align: center;
        }

        .laporan {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        .total {
            margin-top: 20px;
            border-top: 2px solid #000;
            padding-top: 10px;
        }

        .total p {
            margin: 5px 0;
        }

        .total h2 {
            margin-bottom: 5px;
        }

        .mengetahui {
            margin-top: 20px;
            text-align: right;
        }
        @media print {
            #btn-print {
                display: none;
            }
            #btn-back {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="kop">
        <p>PT. BUMI INDAH PERSADA</p>
        <p>LAPORAN BULAN <?= strtoupper(bulanIndonesia($angkaBulan)) ?></p>
        <p>Jalan Masjid Kalidahu RT.011 RW.005 Desa Ngeni Kecamatan Wonotirto.</p>
        <p>No.Telp : 085756849375</p>
        <hr>
    </div>

    <div class="laporan">
        <h2>(Laporan Perbulan)</h2>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Jenis Batu</th>
                    <th>Jumlah Transaksi</th>
                    <th>Jumlah Pembelian</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($statements as $key => $value) : ?>
                    <tr>
                        <td><?= $key + 1 ?></td>
                        <td><?= date('d-m-Y',strtotime($value['tanggal'])) ?></td>
                        <td><?= $value['jenis_batu'] ?></td>
                        <td><?= $value['jumlah_transaksi'] ?></td>
                        <td><?= $value['jumlah_batu_terjual'] ?></td>
                        <td><?= $value['jumlah_pendapatan'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="total">
        <h2>Total:</h2>
        <!-- <p><strong>Jumlah barang dibeli:</strong> <span id="total_barang">...</span></p> -->
        <p><strong>Harga (Jumlah uang selama sebulan):</strong> <span id="total_harga"><?= $total['total'] ?></span></p>
    </div>

    <div class="mengetahui">
        <p>Mengetahui,</p>
        <p>Admin</p>
        <p>_________</p>
    </div>
    <div>
        <a id="btn-back" href="http://localhost/web-rpl/resources/views/dashboard/laporan/" class="btn btn-sm btn-primaru">Kembali</a>
        <button id="btn-print" class="" onclick="cetakPrintCrot()">Print</button>
    </div>
    <script>
        const cetakPrintCrot = () => {
            window.print()
        }
    </script>
</body>

</html>