<?php
  session_start();
  include "inc/alert.php";

  if (isset($_SESSION['username'])) {
    echo "<script> location.href = 'login.php'; </script>";
  }

  $message = "Masukkan Kode Reset Password";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistem IoT | Kode Reset Password</title>

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
            if ($_SESSION['status'] == "Kode tidak sesuai") {
              alertType3($_SESSION['status'], "<i class='fas fa-times'></i>");
              session_unset(); session_destroy(); session_start();
            } else {
              alertType1($_SESSION['status'], "<i class='fas fa-check'></i>");
              session_unset(); session_destroy(); session_start();
            }
          }  
        ?> 
      </p> 

      <div class="row">    
        <div class="col-lg-12">
          <form action="verify_reset_password.php" method="POST">
            <div class="input-group mb-3">
              <input type="text" class="form-control" name="code" placeholder="Kode Verifikasi">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-list-ol"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-paper-plane mr-2"></i>Kirim Kode</button>
              </div>
              <!-- /.col -->
            </div>
          </form>
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