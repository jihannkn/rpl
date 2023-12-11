<?php
session_start();
require('../../../../app/Http/Conrtoller/Controller.php');

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
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <form method="post" class="w-full h-screen flex justify-center items-center">
        <div class="space-y-5 rounded-md shadow-sm border-[1.5px] p-3 w-[50%]">
            <div class="border-b border-gray-900/10 pb-8 w-full flex justify-center items-center">
                <div class="w-[80%] mt-3">
                    <h2 class="text-xl font-bold leading-7 text-gray-900">Tambah Stock</h2>
                    <div class="mt-7 grid grid-cols-1 gap-x-6 gap-y-8 ">
                        <div class="sm:col-span-4">
                            <label for="jenis" class="block text-sm font-medium leading-6 text-gray-900">Jenis Batu</label>
                            <div class="mt-2">
                                <select name="jenis" id="jenis" disabled class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6 pl-2">
                                    <option value="" <?= ($_GET["jenis"] === "") ? 'selected' : ''; ?>>Jenis Batu</option>
                                    <option value="Zeolite" <?= ($_GET["jenis"] === "Zeolite") ? 'selected' : ''; ?>>Zeolite</option>
                                    <option value="Balok" <?= ($_GET["jenis"] === "Balok") ? 'selected' : ''; ?>>Balok</option>
                                </select>
                                <input type="hidden" name="jenis_hidden" id="jenis_hidden" value="<?= $_GET["jenis"] ?>">
                            </div>
                            <label for="jumlah_stok" class="block text-sm font-medium leading-6 text-gray-900 mt-3">Jumlah Batu</label>
                            <div class="mt-2">
                                <div class="flex rounded-md shadow-sm border-[1.5px] ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                    <input type="text" name="jumlah_stok" class="block flex-1 border-0 bg-transparent py-1.5 pl-2 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-end gap-x-6">
                <button type="button" class="text-sm font-semibold leading-6 text-gray-900"><a href="http://localhost/web-rpl/resources/views/dashboard/">Cancel</a></button>
                <button name="tambah" class="btn btn-primary btn-md rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Tambah</button>
            </div>
        </div>
    </form>
    <!-- <form method="post">
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
    <a href="http://localhost/web-rpl/resources/views/dashboard/">Kembali</a> -->
    <script>
        document.getElementById('jenis').addEventListener('change', function() {
            document.getElementById('jenis_hidden').value = this.value;
        });
        document.getElementById('jenis_hidden').value = document.getElementById('jenis').value;
        console.log(document.getElementById('jenis_hidden').value)
    </script>
</body>

</html>