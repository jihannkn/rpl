<?php
session_start();
require('../../../app/Http/Conrtoller/Controller.php');
$stocks = getDatas("SELECT * FROM stocks");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<a class="nav-link px-3" href="http://localhost/web-rpl/resources/views/logout/">Sign out</a>
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