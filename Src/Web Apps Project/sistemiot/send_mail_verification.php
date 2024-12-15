<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;

  require('config/database.php');
  session_start();

  function sendmail_verify($email, $reset_password, $email_template){
    require 'plugins/autoload.php';
    $mail = new PHPMailer(true);

    // Server Settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'wtechnoid@gmail.com';
    $mail->Password   = 'xmqwiuplourbodvs';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Recipients
    $mail->setFrom('from@example.com', 'Kelas IoT');
    $mail->addAddress($email, 'User');
    
    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Verifikasi Email';
    $mail->Body    = $email_template;
    
    // Send
    $mail->send();
  }
?>