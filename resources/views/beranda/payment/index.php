<?php
session_start();
require('../../../../app/Http/Conrtoller/Controller.php');
$stock_id = $_GET['stock_id'];
$stock = getDatas("SELECT * FROM stocks WHERE id = '$stock_id'")[0];
$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
</head>

<body>
<a class="nav-link px-3" href="http://localhost/web-rpl/resources/views/logout/">Sign out</a>
    <section>
        <section>
            <a class="kembali" href="http://localhost/web-rpl/resources/views/beranda/">
                <button>
                    <div class="svg-wrapper-1">
                        <div class="svg-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                <path fill="none" d="M0 0h24v24H0z"></path>
                                <path fill="currentColor" d="M1.946 9.315c-.522-.174-.527-.455.01-.634l19.087-6.362c.529-.176.832.12.684.638l-5.454 19.086c-.15.529-.455.547-.679.045L12 14l6-8-8 6-8.054-2.685z"></path>
                            </svg>
                        </div>
                    </div>
                    <span>Back</span>
                </button>
            </a>
            <div class="payment">
                <div class="left">
                    <img src="../../../../public/assets/image/batu<?= $key + 1 ?>.jpg" alt="" />
                </div>
                <div class="right">
                    <h1><?= $stock['jenis'] ?></h1>
                    <h3>
                        <?= $stock['harga'] ?>
                        /ton
                    </h3>
                    <div class="jumlah">
                        <button id="btn-dsc"><i class="fa-solid fa-minus"></i></button>
                        <span id="jumlah" name="jumlah">1</span>
                        <button id="btn-asc"><i class="fa-solid fa-plus"></i></button>
                    </div>
                    <button id="btn-kirim" class="button2">Beli</button>
                </div>
            </div>
        </section>
    </section>
    <script>
        const jumlah = document.querySelector('#jumlah')
        let angka = parseInt(jumlah.textContent)
        
        const btnAsc = document.querySelector("#btn-asc").addEventListener('click', (e) => {
            e.preventDefault();
            angka += 1;
            jumlah.innerHTML = angka
        })

        document.querySelector("#btn-dsc").addEventListener('click', (e) => {
            e.preventDefault()
            if (angka !== 0) {
                angka -= 1;
            }
            jumlah.innerHTML = angka
        })
    </script>
</body>

</html>