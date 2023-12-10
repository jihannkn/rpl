<?php
session_start();
require('../../../../app/Http/Conrtoller/Controller.php');

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
if (isset($_POST["tambah"])) {
    if (updateStocks() > 0) {
        header("Location: http://localhost/web-rpl/resources/views/dashboard/");
    } else {
        echo "
            <script>
                alert('Stok gagal ditambahkan.');
                document.location.href = 'http://localhost/web-rpl/resources/views/dashboard/'
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