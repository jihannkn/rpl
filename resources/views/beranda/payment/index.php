<?php
session_start();
require('../../../../app/Http/Conrtoller/Controller.php');
$stock_id = $_GET['stock_id'];
$stock = getDatas("SELECT * FROM stocks WHERE id = '$stock_id'")[0];
if (!isset($_SESSION['login'])) {
    header('Location: http://localhost/web-rpl/');
    exit;
}

if (isset($_POST["beli-anjing"])) {
    if (setTransaction() > 0) {
        echo "
            <script>
                alert('Transaksi Berhasil.')
                document.location.href = 'http://localhost/web-rpl/resources/views/beranda/'
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Transaksi Gagal.')
                document.location.href = 'http://localhost/web-rpl/resources/views/beranda/'
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
    <!-- <link rel="stylesheet" href="style.css"> -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
</head>

<body>
    <section>
        <section>
            <div class="relative z-10" role="dialog" aria-modal="true">

                <div class="fixed inset-0 hidden bg-gray-500 bg-opacity-75 transition-opacity md:block"></div>

                <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                    <div class="flex min-h-full items-stretch justify-center text-center md:items-center md:px-2 lg:px-4">

                        <div class="flex w-full transform text-left text-base transition md:my-8 md:max-w-2xl md:px-4 lg:max-w-4xl">
                            <div class="relative flex w-full items-center overflow-hidden bg-white px-4 pb-8 pt-14 shadow-2xl sm:px-6 sm:pt-8 md:p-6 lg:p-8">
                                <button type="button" class="absolute right-4 top-4 text-gray-400 hover:text-gray-500 sm:right-6 sm:top-8 md:right-6 md:top-6 lg:right-8 lg:top-8">
                                    <span class="sr-only">Close</span>
                                    <a href="http://localhost/web-rpl/resources/views/beranda/">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </a>
                                </button>

                                <div class="grid w-full grid-cols-1 items-center gap-x-6 gap-y-8 sm:grid-cols-12 lg:gap-x-8">
                                    <div class="aspect-h-3 aspect-w-2 overflow-hidden rounded-lg bg-gray-100 sm:col-span-4 lg:col-span-5">
                                        <img src="../../../../public/assets/image/<?= $_GET["imageUrl"] ?>" alt="Two each of gray, white, and black shirts arranged on table." class="object-cover object-center" />
                                    </div>
                                    <div class="sm:col-span-8 lg:col-span-7">
                                        <h2 class="text-2xl font-bold text-gray-900 sm:pr-12">
                                            <?= $stock['jenis'] ?>
                                        </h2>

                                        <section aria-labelledby="information-heading" class="mt-2">
                                            <p class="text-2xl text-gray-900">Rp <?= $stock['harga'] ?>/ton</p>

                                            <!-- Reviews -->
                                            <div class="mt-6">
                                                <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Stock: <?= $stock["jumlah_stok"] ?> - ton</a>
                                            </div>
                                        </section>

                                        <section aria-labelledby="options-heading" class="mt-10">
                                            <div class="jumlah flex items-center gap-4">
                                                <button id="btn-dsc">
                                                    <i class="fa-solid fa-minus rounded-md border-[1.8px] py-2 px-3 text-sm font-md uppercase hover:bg-gray-50 focus:outline-none sm:flex-1 cursor-pointer bg-white text-gray-900 shadow-sm hover:border-indigo-700 hover:border-[1.8px]"></i>
                                                </button>
                                                <span id="jumlah">1</span>
                                                <button id="btn-asc">
                                                    <i class="fa-solid fa-plus rounded-md border-[1.8px] py-2 px-3 text-sm font-md uppercase hover:bg-gray-50 focus:outline-none sm:flex-1 cursor-pointer bg-white text-gray-900 shadow-sm hover:border-indigo-700 hover:border-[1.8px]"></i>
                                                </button>
                                            </div>
                                            <form action="" method="post">
                                                <input type="hidden" name="jumlah_hidden" id="jumlah_hidden">
                                                <input type="hidden" name="jenis_hidden" id="jenis_hidden" value="<?= $stock["jenis"] ?>">
                                                <button id="btn-kirim" class="button2 mt-6 flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" name="beli-anjing">Beli</button>
                                            </form>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
    <script>
        const jumlah = document.querySelector('#jumlah');
        const jumlahHidden = document.querySelector('#jumlah_hidden');
        jumlahHidden.value = 1
        let angka = parseInt(jumlah.textContent);

        const updateJumlah = () => {
            jumlah.innerHTML = angka;
            jumlahHidden.value = angka;
        };

        const btnAsc = document.querySelector("#btn-asc").addEventListener('click', (e) => {
            e.preventDefault();
            angka += 1;
            updateJumlah();
        });

        document.querySelector("#btn-dsc").addEventListener('click', (e) => {
            e.preventDefault();
            if (angka !== 0) {
                angka -= 1;
            }
            updateJumlah();
        });

        jumlah.addEventListener('input', (e) => {
            angka = parseInt(e.target.textContent) || 0;
            updateJumlah();
        });
    </script>

</body>

</html>