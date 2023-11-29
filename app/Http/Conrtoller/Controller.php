<?php

$connection = mysqli_connect('localhost', 'root', '', 'manajemen');

function dataStore($query) {
    global $connection;
    $data = [];
    $response = mysqli_query($connection, $query);
    while($rows = mysqli_fetch_assoc($response)){
        $data[] = $rows;
    }
    return $data;
}

