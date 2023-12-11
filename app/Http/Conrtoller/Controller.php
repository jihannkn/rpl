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
    $user_np = $_SESSION["auth"]["np"];
    $jumlahBeli = $_POST["jumlah_hidden"];
    $jenis = $_POST["jenis_hidden"];
    $stock = getDatas("SELECT * FROM stocks WHERE jenis = '$jenis'")[0];
    $total = $jumlahBeli * $stock["harga"] * 1000;

    $updateStock = $stock["jumlah_stok"] - $jumlahBeli;

    $queryUp = "UPDATE stocks SET jumlah_stok = '$updateStock' WHERE jenis = '$jenis'";
    $querySet = "INSERT INTO $table VALUES ('','$user_np','$jenis', '$tanggal', '$jumlahBeli', '$total','','')";
    mysqli_query($connection, $queryUp);
    mysqli_query($connection, $querySet);
    return mysqli_affected_rows($connection);
}

function updateCustomer()
{
    global $connection;

    $np = htmlspecialchars($_POST["np"]);
    $oldName = htmlspecialchars($_POST["old_name"]);
    $oldEmail = htmlspecialchars($_POST["old_email"]);
    $oldNoTelp = htmlspecialchars($_POST["old_customer_no_telp"]);
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $alamat = htmlspecialchars($_POST["alamat"]);
    $noTelp = htmlspecialchars($_POST["no_telp"]);

    if (
        strtolower($name) === strtolower($oldName) &&
        strtolower($email) === strtolower($oldEmail) &&
        $noTelp === $oldNoTelp
    ) {
        return true;
    }

    $userNameDuplicated = getDatas("SELECT * FROM users WHERE name = '$name'");
    $userEmailDuplicated = getDatas("SELECT * FROM users WHERE email = '$email'");

    if ($userNameDuplicated && strtolower($name) !== strtolower($oldName) && strtolower($name) === strtolower($userNameDuplicated[0]["name"])) {
        echo "<script>alert('Ws enek jeneng seng podo ah CROT.');</script>";
        return false;
    }

    if ($userEmailDuplicated && strtolower($email) !== strtolower($oldEmail) && strtolower($email) === strtolower($userEmailDuplicated[0]["email"])) {
        echo "<script>alert('Ws enek email seng podo ah CROT.');</script>";
        return false;
    }

    $customerDuplicateChecked = getDatas("SELECT * FROM customers WHERE no_telp = '$noTelp'");
    if ($customerDuplicateChecked && $noTelp !== $oldNoTelp && $noTelp === $customerDuplicateChecked[0]["no_telp"]) {
        echo "<script>alert('Ws enek nomer seng podo ah CROT.');</script>";
        return false;
    }

    $query = "UPDATE users u 
    JOIN customers c ON u.np = c.user_np
    SET 
        u.name = '$name', 
        u.email = '$email',
        c.alamat = '$alamat',
        c.no_telp = '$noTelp'
    WHERE u.np = '$np'";
    mysqli_query($connection, $query);

    return mysqli_affected_rows($connection) > 0;
}


function deleteCustomer($customerId)
{
    global $connection;
    mysqli_begin_transaction($connection);
    try {
        $query = "DELETE customers, users
                  FROM customers
                  INNER JOIN users ON customers.user_id = users.id
                  WHERE customers.id = '$customerId'";

        mysqli_query($connection, $query);

        mysqli_commit($connection);

        return true;
    } catch (Exception $e) {
        mysqli_rollback($connection);
        return false;
    }
}



function createCustomer()
{
    global $connection;

    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $alamat = htmlspecialchars($_POST["alamat"]);
    $noTelp = htmlspecialchars($_POST["no_telp"]);
    $password = htmlspecialchars($_POST["password"]);
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    echo $name . "<br>";
    echo $email . "<br>";
    echo $alamat . "<br>";
    echo $noTelp . "<br>";

    $userNameDuplicated = getDatas("SELECT * FROM users WHERE name = '$name'");
    $userEmailDuplicated = getDatas("SELECT * FROM users WHERE email = '$email'");
    if ($userNameDuplicated) {
        echo "
            <script>
                alert('Ws enek jeneng seng podo ah CROT.');
            </script>
            ";
            return false;
    }
    if ($userEmailDuplicated) {
        echo "
            <script>
                alert('Ws enek jeneng seng podo ah CROT.');
            </script>
            ";
            return false;
    }

    $userQuery = "INSERT INTO users (name, email, password,)
    VALUES ('$name', '$email', '$hashedPassword');
    ";

    mysqli_query($connection, $userQuery); 

    return mysqli_affected_rows($connection);
}
