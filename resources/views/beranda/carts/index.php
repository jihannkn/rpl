<?php
session_start();
require("../../../../app/Http/Conrtoller/Controller.php");
if (!isset($_SESSION['login'])) {
	header('Location: http://localhost/web-rpl/');
	exit;
}
$userId = $_SESSION["auth"]['np'];
$transactions = getDatas("SELECT * FROM transactions WHERE user_np = '$userId'");
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

  <body>
    <div class="h-screen bg-gray-100 pt-10">
      <a href="http://localhost/web-rpl/resources/views/beranda/">Kembali</a>
      <h1 class="mb-10 text-center text-2xl font-bold">Cart Items</h1>
      <div class="mx-auto max-w-5xl justify-center px-6 md:flex md:space-x-6 xl:px-0">
        <!-- List -->
        <div class="rounded-lg md:w-2/3">
          <?php if(count($transactions) > 0) : ?>
          <?php foreach ($transactions as $key => $value) : ?>
            <div class="justify-between mb-6 rounded-lg bg-white p-6 shadow-md sm:flex sm:justify-start">
              <img src="./public/assets/image/batu1.jpg" alt="product-image" class="w-full rounded-lg sm:w-40" />
              <div class="sm:ml-4 sm:flex sm:w-full sm:justify-between">
                <div class="mt-5 sm:mt-0">
                  <h2 class="text-lg font-bold text-gray-900"><?= $value['jenis_batu']?></h2>
                </div>
                <div class="mt-4 flex justify-between sm:space-y-6 sm:mt-0 sm:block sm:space-x-6">
                  <div class="flex items-center border-gray-100">
                    <span class="cursor-pointer rounded-l bg-gray-100 py-1 px-3.5 duration-100 hover:bg-blue-500 hover:text-blue-50"> - </span>
                    <input class="h-8 w-8 border bg-white text-center text-xs outline-none" type="number" value="<?= $value['jumlah']?>" min="1" />
                    <span class="cursor-pointer rounded-r bg-gray-100 py-1 px-3 duration-100 hover:bg-blue-500 hover:text-blue-50"> + </span>
                  </div>
                  <div class="flex items-center space-x-4">
                    <p class="text-sm"><?= $value['total'] ?></p>
                    <a href="http://localhost/web-rpl/resources/views/beranda/carts/delete?id=<?=$value['id']?>" onclick="confirm('yakin membatalkan?')">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 cursor-pointer duration-150 hover:text-red-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                      </svg>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>

          <?php else :  ?>

            <h1>Beli dulu lah anjeng</h1>

          <?php endif; ?>
        </div>
        <!-- Sub total -->
        <!-- <div class="mt-6 h-full rounded-lg border bg-white p-6 shadow-md md:mt-0 md:w-1/3">
          <div class="mb-2 flex justify-between">
            <p class="text-gray-700">Subtotal</p>
            <p class="text-gray-700">Rp 150.000</p>
          </div>
          <div class="flex justify-between">
            <p class="text-gray-700">Tax</p>
            <p class="text-gray-700">Rp 0</p>
          </div>
          <hr class="my-4" />
          <div class="flex justify-between">
            <p class="text-lg font-bold">Total</p>
            <div class="">
              <p class="mb-1 text-lg font-bold">Rp 00000</p>
            </div>
          </div>
          <button class="mt-6 w-full rounded-md bg-blue-500 py-1.5 font-medium text-blue-50 hover:bg-blue-600">Check out</button>
        </div> -->
      </div>
    </div>
  </body>
</body>

</html>