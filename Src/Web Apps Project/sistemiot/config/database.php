<?php
    $serverName = "localhost";
    $username = "root";
    $password = "";
    $databaseName = "sistem_iot";

    $conn = mysqli_connect($serverName, $username, $password, $databaseName);

    if (!$conn) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }

    // echo "Koneksi berhasil";
?>