<?php
    use plugins\PHPMailer\PHPMailer\PHPMailer;
    use plugins\PHPMailer\PHPMailer\SMTP;
    use plugins\PHPMailer\PHPMailer\Exception;

    session_start();
    include "config/database.php";

    function sendmail_verify($email, $reset_password, $email_template){
        // include "plugins/autoload.php";
        $mail = new PHPMailer(true);

        // Server Settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'test.jagatcoding@gmail.com';
        $mail->Password   = 'rpyoruhiqvcwlkkw';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('from@kelasiot.com', 'Kelas IoT');
        $mail->addAddress($email, 'User');
        $mail->addReplyTo('no-reply@kelasiot.com', 'information');

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Verifikasi Email';
        $mail->Body    = $email_template;
        $mail->send();
        echo "Email Terkirim";
    }
?>