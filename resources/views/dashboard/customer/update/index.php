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

$customer_np = $_GET["np"];
$customer = getDatas("SELECT
    users.np,
    users.name,
    users.email,
    customers.alamat,
    customers.no_telp AS customer_no_telp,
    customers.created_at AS customer_created_at,
    customers.updated_at AS customer_updated_at
FROM
    users
JOIN
    customers ON users.np = customers.user_np
WHERE
    users.np = '$customer_np';
")[0];

if (isset($_POST["update_customer"])) {
    if (updateCustomer() > 0) {
        header("Location: http://localhost/web-rpl/resources/views/dashboard/customer/");
    } else {
        echo "
        <script>
        alert('Data gagal disimpan');
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <form method="post" class="w-full h-screen flex justify-center items-center">
        <div class="space-y-5 rounded-md shadow-sm border-[1.5px] p-3 w-[50%]">
            <div class="border-b border-gray-900/10 pb-8 w-full flex justify-center items-center">
                <div class="w-[80%] mt-3">
                    <h2 class="text-xl font-bold leading-7 text-gray-900">Ubah Data</h2>
                    <div class="mt-7 grid grid-cols-1 gap-x-6 gap-y-8 ">
                        <div class="sm:col-span-4">
                            <input type="hidden" name="np" value="<?= $customer["np"] ?>">
                            <input type="hidden" name="old_name" value="<?= $customer["name"] ?>">
                            <input type="hidden" name="old_email" value="<?= $customer["email"] ?>">
                            <input type="hidden" name="old_customer_no_telp" value="<?= $customer["customer_no_telp"] ?>">
                            <label for="username" class="block text-sm font-medium leading-6 text-gray-900">Nama</label>
                            <div class="mt-2">
                                <div class="flex rounded-md shadow-sm border-[1.5px] ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                    <input type="text" name="name" value="<?= $customer["name"] ?>" class="block flex-1 border-0 bg-transparent py-1.5 pl-2 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6">
                                </div>

                            </div>
                            <label for="username" class="block text-sm font-medium leading-6 text-gray-900 mt-3">Email</label>
                            <div class="mt-2">
                                <div class="flex rounded-md shadow-sm border-[1.5px] ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                    <input type="email" name="email" value="<?= $customer["email"] ?>" class="block flex-1 border-0 bg-transparent py-1.5 pl-2 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                            <label for="username" class="block text-sm font-medium leading-6 text-gray-900 mt-3">Alamat</label>
                            <div class="mt-2">
                                <div class="flex rounded-md shadow-sm border-[1.5px] ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                    <input type="text" name="alamat" value="<?= $customer["alamat"] ?>" class="block flex-1 border-0 bg-transparent py-1.5 pl-2 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                            <label for="username" class="block text-sm font-medium leading-6 text-gray-900 mt-3">No Telephone</label>
                            <div class="mt-2">
                                <div class="flex rounded-md shadow-sm border-[1.5px] ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                    <input type="text" name="no_telp" value="<?= $customer["customer_no_telp"] ?>" class="block flex-1 border-0 bg-transparent py-1.5 pl-2 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-end gap-x-6">
                <button type="button" class="text-sm font-semibold leading-6 text-gray-900"><a href="http://localhost/web-rpl/resources/views/dashboard/customer/">Cancel</a></button>
                <button name="update_customer" type="submit" class="btn btn-primary btn-md rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
            </div>
        </div>
    </form>
    <!-- Js -->
    <script src="../dashboard.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>