<?php

$connection = mysqli_connect('localhost', 'root', '', 'manajemen');

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

function updateBatu()
{
    global $connection;
    $table = 'stok';

    $jenis = $_POST["jenis_batu"];
    $jumlahBaru = $_POST["jumlah_stok"];

    $stones = getDatas("SELECT * FROM stok WHERE jenis_batu = '$jenis'")[0];
    $jumlahAwal = $stones["jumlah_stok"];
    $jumlahAkhir = $jumlahBaru + $jumlahAwal;

    $query = "UPDATE $table SET jumlah_stok = '$jumlahAkhir' WHERE jenis_batu = '$jenis'";
    mysqli_query($connection, $query);
    return mysqli_affected_rows($connection);
}
