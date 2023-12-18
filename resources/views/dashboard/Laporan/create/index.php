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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (createStatement() > 0) {
        echo "
            <script>
                alert('Data Berhasil Ditambahkan');
                document.location.href = 'http://localhost/web-rpl/resources/views/dashboard/laporan'
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Data Gagal Ditambahkan');
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
    <form action="" method="post" class="w-full h-full flex justify-center items-center py-[50px]">
        <div class="space-y-5 rounded-md shadow-sm border-[1.5px] p-3 w-[70%]">
            <div class="border-b border-gray-900/10 pb-8 w-full flex justify-center items-center">
                <div class="w-[80%] mt-3">
                    <h2 class="text-xl font-bold leading-7 text-gray-900">
                        Buat Laporan
                    </h2>
                    <div class="mt-7 grid grid-cols-1 gap-x-6 gap-y-8">
                        <div class="sm:col-span-4">
                            <div class="flex justify-center items-center w-full gap-[10px]">
                                <label for="" class="block text-sm font-medium leading-6 text-gray-900">No Laporan</label>
                                <div class="mt-2 w-[50%]">
                                    <div class="flex rounded-md shadow-sm border-[1.5px] ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 w-full">
                                        <input type="text" name="nomor_laporan" value="<?= $nextNl ?>" readonly class="block flex-1 border-0 bg-transparent py-1.5 pl-2 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" />
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-center items-center w-full gap-[10px]">
                                <label for="" class="block text-sm font-medium leading-6 text-gray-900">Tanggal Laporan</label>
                                <div class="mt-2 w-[50%]">
                                    <div class="flex rounded-md shadow-sm border-[1.5px] ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                        <input type="date" name="tanggal" value="<?= date("Y-m-d") ?>" readonly class="block flex-1 border-0 bg-transparent py-1.5 pl-2 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" />
                                    </div>
                                </div>
                            </div>
                            <div class="bungkus w-full flex gap-[15px] mt-[20px]">
                                <div class="kiri w-[50%]">
                                    <div class="flex justify-between items-center w-full">
                                        <label for="" class="block text-sm font-medium leading-6 text-gray-900">Jenis Batu
                                        </label>
                                        <div class="mt-2 w-[70%]">
                                            <div class="flex rounded-md shadow-sm border-[1.5px] ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                                <input type="text" name="jenis_batu_zeolite" value="Zeolite" class="block flex-1 border-0 bg-transparent py-1.5 pl-2 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-center w-full">
                                        <label for="" class="block text-sm font-medium leading-6 text-gray-900">Jumlah Batu Terjual</label>
                                        <div class="mt-2 w-[60%]">
                                            <div class="flex rounded-md shadow-sm border-[1.5px] ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                                <input type="text" name="batu_terjual_zeolite" value="<?= $totalTerjualZeolite['jumlah_batu'] ?>" readonly class="block flex-1 border-0 bg-transparent py-1.5 pl-2 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-center w-full">
                                        <label for="" class="block text-sm font-medium leading-6 text-gray-900">Jumlah Transaksi</label>
                                        <div class="mt-2 w-[60%]">
                                            <div class="flex rounded-md shadow-sm border-[1.5px] ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                                <input type="text" name="jumlah_transaksi_zeolite" value="<?= count($transactionZeolite) ?>" readonly class="block flex-1 border-0 bg-transparent py-1.5 pl-2 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-center w-full">
                                        <label for="" class="block text-sm font-medium leading-6 text-gray-900">Jumlah Pendapatan</label>
                                        <div class="mt-2 w-[60%]">
                                            <div class="flex rounded-md shadow-sm border-[1.5px] ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                                <input type="text" name="jumlah_pendapatan_zeolite" value="<?= $totalPendapatanZeolite['total_semua'] ?>" readonly class="block flex-1 border-0 bg-transparent py-1.5 pl-2 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="kanan w-[50%]">
                                    <div class="flex justify-between items-center w-full">
                                        <label for="" class="block text-sm font-medium leading-6 text-gray-900">Jenis Batu
                                        </label>
                                        <div class="mt-2 w-[70%]">
                                            <div class="flex rounded-md shadow-sm border-[1.5px] ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                                <input type="text" name="jenis_batu_balok" value="Balok" class="block flex-1 border-0 bg-transparent py-1.5 pl-2 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-center w-full">
                                        <label for="" class="block text-sm font-medium leading-6 text-gray-900">Jumlah Batu Terjual</label>
                                        <div class="mt-2 w-[60%]">
                                            <div class="flex rounded-md shadow-sm border-[1.5px] ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                                <input type="text" name="batu_terjual_balok" value="<?= $totalTerjualBalok['jumlah_batu'] ?>" readonly class="block flex-1 border-0 bg-transparent py-1.5 pl-2 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-center w-full">
                                        <label for="" class="block text-sm font-medium leading-6 text-gray-900">Jumlah Transaksi</label>
                                        <div class="mt-2 w-[60%]">
                                            <div class="flex rounded-md shadow-sm border-[1.5px] ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                                <input type="text" name="jumlah_transaksi_balok" value="<?= count($transactionBalok) ?>" readonly class="block flex-1 border-0 bg-transparent py-1.5 pl-2 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-center w-full">
                                        <label for="" class="block text-sm font-medium leading-6 text-gray-900">Jumlah Pendapatan</label>
                                        <div class="mt-2 w-[60%]">
                                            <div class="flex rounded-md shadow-sm border-[1.5px] ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                                <input type="text" name="jumlah_pendapatan_balok" value="<?= $totalPendapatanBalok['total_semua'] ?>" readonly class="block flex-1 border-0 bg-transparent py-1.5 pl-2 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-end gap-x-6">
                <button type="button" class="text-sm font-semibold leading-6 text-gray-900">
                    <a href="http://localhost/web-rpl/resources/views/dashboard/laporan/">Cancel</a>
                </button>
                <button name="create_customer" type="submit" class="btn btn-primary btn-md rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Buat Laporan
                </button>
            </div>
        </div>
    </form>
</body>

</html>