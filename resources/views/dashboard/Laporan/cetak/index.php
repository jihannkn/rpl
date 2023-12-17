<?php
session_start();
require("../../../../../app/Http/Conrtoller/Controller.php");
if (!isset($_SESSION['login'])) {
    header('Location: http://localhost/web-rpl/');
    exit;
}

$noLap = $_GET['nomor'];
$statements = getDatas("SELECT * FROM statements WHERE nomor_laporan = '$noLap'");
$total = getDatas("SELECT SUM(jumlah_pendapatan) AS total FROM statements")[0];
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
        }
    </style>
</head>

<body>
    <div class="kop">
        <p>PT. BUMI INDAH PERSADA</p>
        <p>LAPORAN BULAN....</p>
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
        <button id="btn-print" class="" onclick="cetakPrintCrot()">Cetak</button>
    </div>
    <script>
        const cetakPrintCrot = () => {
            window.print()
        }
    </script>
</body>

</html>