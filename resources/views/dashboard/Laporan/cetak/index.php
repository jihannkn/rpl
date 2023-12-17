<!DOCTYPE html>
<html>

<head>
    <title>Laporan Bulanan</title>
    <style>
        /* Styles untuk laporan */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
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
                    <th>Nama Perusahaan</th>
                    <th>Jenis Batu</th>
                    <th>Jumlah Pembelian</th>
                    <th>Harga</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data laporan diletakkan di sini -->
                <!-- Contoh baris data -->
                <tr>
                    <td>1</td>
                    <td>Nama Perusahaan A</td>
                    <td>Batu X</td>
                    <td>100</td>
                    <td>50000</td>
                    <td>2023-12-01</td>
                </tr>
                <!-- Baris data lainnya akan ditempatkan di sini -->
            </tbody>
        </table>
    </div>

    <div class="total">
        <h2>Total:</h2>
        <p><strong>Jumlah barang dibeli:</strong> <span id="total_barang">...</span></p>
        <p><strong>Harga (Jumlah uang selama sebulan):</strong> <span id="total_harga">...</span></p>
    </div>

    <div class="mengetahui">
        <p>Mengetahui,</p>
        <p>Admin</p>
        <p>_________</p>
    </div>
    <script>
        window.print()
    </script>
</body>

</html>
