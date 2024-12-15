<?php
    include "sendmail_verify.php";

    function generateRandomString ($length) {
        $characters = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $charactersLength = strlen($characters);
        $randomString = '';

        for($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $email = $_POST['email'];
        $reset_password = generateRandomString(12);

        $email_template = "
            <h2>Berikut Kode Reset Password Anda:</h2><br>
            <h4>$reset_password</h4><br>
            <p>Kode tersebut hanya berlaku satu kali, silakan dipakai sebaik mungkin.</p>
        ";
        
        $query_select = "SELECT * FROM user WHERE email = '$email'";
        $sql_select = mysqli_query($conn, $query_select);
        $result = mysqli_fetch_assoc($sql_select);

        if ($result) {
            if ($result['reset_password'] != '0') {
                $_SESSION['status'] = "Kode sudah dikirimkan";
                echo "<script> location.href = 'forgot-password.php'; </script>";
            }
            else {
                $query_update = "UPDATE user SET reset_password = '$reset_password' WHERE email = '$email'";

                if ($conn->query($query_update) === TRUE) {
                    sendmail_verify($email, $reset_password, $email_template);
                    $_SESSION['status'] = "Kode RESET telah dikirimkan";
                    echo "<script> location.href = 'recover-password.php'; </script>";
                }
                else {
                    $_SESSION['status'] = "Email belum terdaftar";
                    echo "<script> location.href = 'index.php'; </script>";
                }
            }
        }
        else {
            $_SESSION['status'] = "Email belum terdaftar";
            echo  "<script> location.href = 'forgot-password.php'; </script>";
        }
        $conn->close();
    }
?>