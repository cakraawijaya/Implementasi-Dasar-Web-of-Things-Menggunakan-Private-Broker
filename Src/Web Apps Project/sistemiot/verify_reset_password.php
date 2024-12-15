<?php
    session_start();
    include "config/database.php";

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $code = $_POST['code'];
        $query = "SELECT * FROM user WHERE reset_password = '$code'";
        $sql = mysqli_query($conn, $query);
        $result = mysqli_fetch_assoc($sql);

        if ($result) {
            $_SESSION['code'] = $code;
            echo "<script> location.href = 'reset_password.php'; </script>";
        }
        else {
            $_SESSION['status'] = "Kode tidak sesuai";
            echo "<script> location.href = 'input_verification_code.php'; </script>";
        }
    }
?>