<?php

$connection = mysqli_connect('localhost', 'root', '', 'bumipersada');

function getDatas($query)
{
    global $connection;
    $data = [];
    $response = mysqli_query($connection, $query);
    while ($rows = mysqli_fetch_assoc($response)) {
        $data[] = $rows;
    }
    return $data;
}


function storeData()
{
    global $connection;
    $table = "CONTOH";
    $data1 = $_POST["data_1"];
    $data2 = $_POST["data_2"];

    $query = "INSERT INTO $table VALUES ('$data1','$data2')";
    mysqli_query($connection, $query);
    return mysqli_affected_rows($connection);
}

function updateStocks()
{
    // echo $_POST['jenis'];
    // die;
    global $connection;
    $table = 'stocks';

    $jenis = $_POST["jenis"];
    $jumlahBaru = $_POST["jumlah_stok"];

    $stones = getDatas("SELECT * FROM stocks WHERE jenis = '$jenis'")[0];

    $jumlahAwal = $stones["jumlah_stok"];
    $jumlahAkhir = $jumlahBaru + $jumlahAwal;

    $query = "UPDATE $table SET jumlah_stok = '$jumlahAkhir' WHERE jenis = '$jenis'";
    mysqli_query($connection, $query);
    return mysqli_affected_rows($connection);
}
