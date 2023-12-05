<?php
session_start();
require('../../../app/Http/Conrtoller/Controller.php');
$stocks = getDatas("SELECT * FROM stocks");
$user = $_SESSION['user'];
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
    <section>
        <?php foreach ($stocks as $key => $stock) : ?>
            <div class="card">
                <h1><?php echo $stock["jenis"] ?></h1>
                <img src="../../../public/assets/image/balok.jpg" alt="">
                <a href="http://localhost/web-rpl/resources/views/beranda/payment?stock_id=<?=$stock["id"]?>">Go</a>
            </div>
        <?php endforeach; ?>
    </section>
</body>

</html>