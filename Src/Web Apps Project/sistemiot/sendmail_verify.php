<?php
    use plugins\PHPMailer\PHPMailer\PHPMailer;
    use plugins\PHPMailer\PHPMailer\SMTP;
    use plugins\PHPMailer\PHPMailer\Exception;

    session_start();
    include "config/database.php";

    function sendmail_verify($email, $reset_password, $email_template){
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'kelasiot.devan@gmail.com';
        $mail->Password   = 'rpyoruhiqvcwlkkw';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTLS;
        $mail->Port       = 587;

        $mail->setFrom('from@kelasiot.com', 'Kelas IoT');
        $mail->addAddress($email, 'User');
        $mail->addReplyTo('no-reply@kelasiot.com', 'information');

        $mail->isHTML(true);
        $mail->Subject = 'Verifikasi Email';
        $mail->Body    = $email_template;

        $mail->send();
        echo "Email Terkirim";
    }
?>