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


function updateStocks()
{
    global $connection;
    $table = 'stocks';
    $jenis = $_POST["jenis_hidden"];
    $jumlahBaru = $_POST["jumlah_stok"];

    $stones = getDatas("SELECT * FROM stocks WHERE jenis = '$jenis'")[0];

    $jumlahAwal = $stones["jumlah_stok"];
    $jumlahAkhir = $jumlahBaru + $jumlahAwal;

    $query = "UPDATE $table SET jumlah_stok = '$jumlahAkhir' WHERE jenis = '$jenis'";
    mysqli_query($connection, $query);
    return mysqli_affected_rows($connection);
}


function setTransaction()
{
    global $connection;
    $table = 'transactions';
    $tanggal = date('Y-m-d H:i:s');
    $user_id = $_SESSION["auth"]["id"];
    $jumlahBeli = $_POST["jumlah_hidden"];
    $jenis = $_POST["jenis_hidden"];
    $stock = getDatas("SELECT * FROM stocks WHERE jenis = '$jenis'")[0];
    $total = $jumlahBeli * $stock["harga"] * 1000;

    $updateStock = $stock["jumlah_stok"] - $jumlahBeli;

    $queryUp = "UPDATE stocks SET jumlah_stok = '$updateStock' WHERE jenis = '$jenis'";
    $querySet = "INSERT INTO $table VALUES ('','$user_id','$jenis', '$tanggal', '$jumlahBeli', '$total','','')";
    mysqli_query($connection, $queryUp);
    mysqli_query($connection, $querySet);
    return mysqli_affected_rows($connection);
}


function deleteCustomer($customerId)
{
    global $connection;
    $query = "SELECT user_id FROM customers WHERE id = '$customerId'";
    $result = mysqli_query($connection, $query);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        $userId = $row['user_id'];
        mysqli_begin_transaction($connection);

        try {
            $queryCustomer = "DELETE FROM customers WHERE id = '$customerId'";
            mysqli_query($connection, $queryCustomer);

            $queryUser = "DELETE FROM users WHERE id = '$userId'";
            mysqli_query($connection, $queryUser);

            mysqli_commit($connection);

            return true;
        } catch (Exception $e) {
            mysqli_rollback($connection);
            return false;
        }
    }

    return false;
}
function updateCustomer()
{
    global $connection;
    
    $id = htmlspecialchars($_POST["id"]);
    $oldName = htmlspecialchars($_POST["old_name"]);
    $oldEmail = htmlspecialchars($_POST["old_email"]);
    $oldNoTelp = htmlspecialchars($_POST["old_customer_no_telp"]);
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $alamat = htmlspecialchars($_POST["alamat"]);
    $noTelp = htmlspecialchars($_POST["customer_no_telp"]);

    // echo "ID: " . $id . "<br>";
    // echo "Old Name: " . $oldName . "<br>";
    // echo "Old Email: " . $oldEmail . "<br>";
    // echo "Old No Telp: " . $oldNoTelp . "<br>";
    // echo "Name: " . $name . "<br>";
    // echo "Email: " . $email . "<br>";
    // echo "Alamat: " . $alamat . "<br>";
    // echo "No Telp: " . $noTelp . "<br>";

    $userDuplicateChecked = getDatas("SELECT * FROM users WHERE id = '$id'");
    if ($userDuplicateChecked) {
        if ($name !== $oldName && strtolower($name) === strtolower($userDuplicateChecked[0]["name"])) {
            echo "
            <script>
            alert('Ws enek jeneng seng podo ah CROT.');
            </script>
            ";
            return false;
        }
        if ($email !== $oldEmail && strtolower($email) === strtolower($userDuplicateChecked[0]["email"])) {
            echo "
            <script>
            alert('Ws enek email seng podo ah CROT.');
            </script>
            ";
            return false;
        }
    }

    $userQuery = "UPDATE users SET name = '$name', email = '$email' WHERE id = '$id'";
    mysqli_query($connection, $userQuery);

    $customerDuplicateChecked = getDatas("SELECT * FROM customers WHERE user_id = '$id'");
    if ($customerDuplicateChecked) {
        if ($noTelp !== $oldNoTelp && $noTelp === $customerDuplicateChecked[0]["no_telp"]) {
            echo "
            <script>
            alert('Ws enek nomer seng podo ah CROT.');
            </script>
            ";
            return false;
        }
    }

    $customerQuery = "UPDATE customers SET alamat = '$alamat', no_telp = '$noTelp' WHERE user_id = '$id'";
    mysqli_query($connection, $customerQuery);

    return mysqli_affected_rows($connection);
}

