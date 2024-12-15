<?php
  session_start();
  include "inc/alert.php";

  if (isset($_SESSION['username'])) {
    echo "<script> location.href = 'login.php'; </script>";
  }

  $message = "Anda lupa password?&nbsp;&nbsp;Jangan khawatir, disini Anda akan memperoleh password baru dengan mudah.";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistem IoT | Lupa Password</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition register-page">
<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <h1><b>Sistem</b> IoT</h1>
    </div> 
    <div class="card-body">  
      <p class="login-box-msg" style="text-align:center;">
        <?php    
          echo $message;    
             
          if (isset($_SESSION['status']) == true) {
            if ($_SESSION['status'] == "Email belum terdaftar") {
              alertType3($_SESSION['status'], "<i class='fas fa-times'></i>");
              setcookie('last_timestamps', '', time() - 1);
              session_unset();
              session_destroy();
            } 
            else {
              alertType1($_SESSION['status'], "<i class='fas fa-check'></i>");
              setcookie('last_timestamps', '', time() - 1);
              session_unset();
              session_destroy();
            }
          } 
        ?> 
      </p> 

      <div class="row">    
        <div class="col-lg-12">
          <form action="send_resetpass.php" method="POST">
            <div class="input-group mb-3">
              <input type="email" class="form-control" name="email" placeholder="Email">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-paper-plane mr-2"></i>Meminta password baru</button>
              </div>
              <!-- /.col -->
            </div>
          </form>
          <p class="mt-4 mb-1">
            Belum punya akun? <a type="button" href="register.php">Daftar</a>
          </p>
        </div>
      </div>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
