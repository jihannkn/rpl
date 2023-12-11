<?php
session_start();
require('../../../app/Http/Conrtoller/Controller.php');
$stocks = getDatas("SELECT * FROM stocks");
if (!isset($_SESSION['login'])) {
    header('Location: http://localhost/web-rpl/');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
      integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <nav class="mx-auto flex max-w-7xl items-center justify-between px-6 py-2 bg-[#6558d3]">
        <div class="flex lg:flex-1">
            <a href="#" class="-m-1.5 p-1.5">
                <img class="h-12 w-auto" src="../../../public/assets/image/logoPT.png" alt="">
            </a>
        </div>
        <div class="flex flex-1 justify-end items-center gap-6">
            <div class="flex items-center gap-2">
                <i class="fa-regular fa-user text-[14px] font-semibold text-gray-900 text-white"></i>
                <a href="#" class="text-sm font-semibold leading-6 text-gray-900 text-white">Profile</a>
            </div>
            <a href="http://localhost/web-rpl/resources/views/logout/" class="text-sm font-semibold leading-6 text-gray-900 text-white">Sign out <span aria-hidden="true">&rarr;</span></a>
        </div>
    </nav>
    <section>
        <?php foreach ($stocks as $key => $stock) : ?>
            <div class="plan">
                <div class="inner">
                    <span class="pricing">
                        <span> <?php echo $stock["jenis"] ?> </span>
                    </span>
                    <img src="../../../public/assets/image/batu<?= $key + 1 ?>.jpg" alt="" />
                    <div class="action">
                        <a class="button" href="http://localhost/web-rpl/resources/views/beranda/payment?stock_id=<?= $stock["id"] ?>&imageUrl=batu<?= $key + 1 ?>.jpg"> Buy Now </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </section>
</body>

</html>