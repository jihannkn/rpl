<?php
session_start();
require('../../../../app/Http/Conrtoller/Controller.php');
$stock_id = $_GET['stock_id'];
$stock = getDatas("SELECT * FROM stocks WHERE id = '$stock_id'")[0];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
        <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
</head>
<body>
    <section>
        <div class="payment">
            <div class="left">
                <img src="../../../../public/assets/image/balok.jpg" alt="">
            </div>
            <div class="right">
                <h1><?=$stock['jenis']?></h1>
                <h3>Rp <?= $stock['harga'] ?> /ton</h3>
                <div class="jumlah">
                    <button id="btn-dsc"><i class="fa-solid fa-minus"></i></button>
                    <span id="jumlah">1</span>
                    <button id="btn-asc"><i class="fa-solid fa-plus"></i></button>
                </div>
                <button>Beli</button>
            </div>
        </div>
    </section>
    <script>
        const btnAsc = document.querySelector("#btn-asc")
        const btnDsc = document.querySelector("#btn-dsc")
        const jumlah = document.querySelector('#jumlah')
        console.log(btnAsc)
        console.log(btnDsc)
        console.log(jumlah)
        let angka = parseInt(jumlah.textContent)
        console.log(angka)
        btnAsc.addEventListener('click', (e) => {
            e.preventDefault();
            angka += 1;
            jumlah.innerHTML = angka
        })
        btnDsc.addEventListener('click', (e) => {
            e.preventDefault()
            if (angka !== 0) {
                angka -= 1;
            }
            jumlah.innerHTML = angka
        })
    </script>
</body>
</html>