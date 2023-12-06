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
            <label for="jenis">Jenis Batu</label>
            <select name="jenis" id="jenis" disabled>
                <option value="" <?= ($_GET["jenis"] === "") ? 'selected' : ''; ?>>Jenis Batu</option>
                <option value="Zeolite" <?= ($_GET["jenis"] === "Zeolite") ? 'selected' : ''; ?>>Zeolite</option>
                <option value="Balok" <?= ($_GET["jenis"] === "Balok") ? 'selected' : ''; ?>>Balok</option>
            </select>
            <input type="hidden" name="jenis_hidden" id="jenis_hidden" value="<?= $_GET["jenis"] ?>">
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
    <script>
        document.getElementById('jenis').addEventListener('change', function() {
            document.getElementById('jenis_hidden').value = this.value;
        });
        document.getElementById('jenis_hidden').value = document.getElementById('jenis').value;
        console.log(document.getElementById('jenis_hidden').value)
    </script>
</body>

</html>