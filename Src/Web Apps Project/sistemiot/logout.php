<?php 
    session_start();

    session_unset();
    session_destroy();

    setcookie('username', '', time() - 3600);

    echo "<script> location.href = 'login.php'; </script>";
?>