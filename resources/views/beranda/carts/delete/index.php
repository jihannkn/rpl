<?php
session_start();
require("../../../../../app/Http/Conrtoller/Controller.php");
if (!isset($_SESSION['login'])) {
	header('Location: http://localhost/web-rpl/');
	exit;
}

$transactionId = $_GET['id'];

if(userDeteleTransaction($transactionId) > 0){
    echo "
        <script>
            alert('Transaksi telah dibatalkan.');
            document.location.href = 'http://localhost/web-rpl/resources/views/beranda/carts/';
        </script>
    ";
} else {
    echo "
        <script>
            alert('Terjadi suatu kesalahan.');
        </script>
    ";

}