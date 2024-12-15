<?php  
  require('send_mail_verification.php');

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
    
    $select = mysqli_query($conn, "SELECT * FROM user WHERE email = '$email'");
    $result = mysqli_fetch_assoc($select);

    if ($result) {
      if ($result['reset_password'] != '0') {
          $_SESSION['status'] = "Kode sudah dikirimkan";
          echo "<script> location.href = 'forgot_password.php'; </script>";
      }
      else {
        $update = "UPDATE user SET reset_password = '$reset_password' WHERE email = '$email'";

        if ($conn->query($update) === TRUE) {
          sendmail_verify($email, $reset_password, $email_template);
          $_SESSION['status'] = "Kode RESET telah dikirimkan";
          echo "<script> location.href = 'input_verification_code.php'; </script>";
        }
        else {
          $_SESSION['status'] = "Email belum terdaftar";
          echo "<script> location.href = 'index.php'; </script>";
        }
      }
    }
    else {
      $_SESSION['status'] = "Email belum terdaftar";
      echo "<script> location.href = 'forgot_password.php'; </script>";
    }
    $conn->close();
  }
?>