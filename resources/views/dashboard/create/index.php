<?php
require('../../../../app/Http/Conrtoller/Controller.php');

if (isset($_POST["tambah"])) {
    if (updateBatu()){
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
            <label for="jenis">Jenis Batu</label>
            <select name="jenis" id="jenis">
                <option value="" active>Jenis Batu</option>
                <option value="ziolit">Ziolit</option>
                <option value="balok">Balok</option>
            </select>
        </div>
        <div>
            <label for="jumlah">Jumlah Batu</label>
            <input type="text" name="jumlah">
        </div>
        <div>
            <button name="tambah">Tambah</button>
        </div>
    </form>
    <a href="http://localhost/web-rpl/resources/views/dashboard/">Kembali</a>
</body>
</html>