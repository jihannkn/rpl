<?php
session_start();
require("../../../../../app/Http/Conrtoller/Controller.php");
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
					<h2 class="text-xl font-bold leading-7 text-gray-900">Tambah Data</h2>
					<div class="mt-7 grid grid-cols-1 gap-x-6 gap-y-8 ">
						<div class="sm:col-span-4">
							<input type="hidden" name="id" value="<?= $customer["id"] ?>">
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
</body>

</html>