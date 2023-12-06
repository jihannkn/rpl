<?php
session_start();
require('../../../../app/Http/Conrtoller/Controller.php');

if (isset($_POST["tambah"])) {
    if (updateStocks()) {
        header("Location: http://localhost/web-rpl/resources/views/dashboard/");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="post">
        <div>
            <label for="jenis_batu">Jenis Batu</label>
            <select name="jenis" id="jenis">
                <option value="" active>Jenis Batu</option>
                <option value="Zeolite">Zeolite</option>
                <option value="Balok">Balok</option>
            </select>
        </div>
        <div>
            <label for="jumlah_stok">Jumlah Batu</label>
            <input type="text" name="jumlah_stok">
        </div>
        <div>
            <button name="tambah">Tambah</button>
        </div>
    </form>
    <a href="http://localhost/web-rpl/resources/views/dashboard/">Kembali</a>
</body>

</html>