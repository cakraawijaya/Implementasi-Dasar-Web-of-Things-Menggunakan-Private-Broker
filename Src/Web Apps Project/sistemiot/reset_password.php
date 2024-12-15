<?php
  session_start();
  include "config/database.php";
  include "inc/alert.php";

  if (isset($_SESSION['username'])) {
    echo "<script> location.href = 'login.php'; </script>";
  }

  $message = "Silakan setel ulang password Anda di bawah ini";

  if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];
    $code = $_SESSION['code'];

    $select = mysqli_query($conn, "SELECT * FROM user WHERE reset_password = '$code'");
    $result = mysqli_fetch_assoc($select);

    if ($result) {
      if ($password1 !== $password2) {
        $message = "<b style='color:red;'><i class='fas fa-exclamation-triangle'></i> Password tidak sama!</b>";
      }
      else {
        $password = password_hash($_POST['password2'], PASSWORD_DEFAULT);
        $update = "UPDATE user SET password = '$password', reset_password = '0' WHERE reset_password = '$code'";
        
        if ($conn->query($update) === TRUE) {
          $_SESSION['status'] = "Password berhasil diatur ulang";
          echo "<script> location.href = 'login.php' </script>";
        }
      }
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistem IoT | Atur Ulang Password</title>

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
    
    <form action="" method="POST">
      <div class="card-body">
        <p class="login-box-msg">
          <?php 
            echo $message;
          ?>
        </p>

        <div class="row">    
          <div class="col-lg-12 mt-2">
            <div class="input-group mb-3">
              <div class="input-group-append">
                <div class="input-group-text" style="padding-right:12px;">
                  <span class="fas fa-lock"></span>
                </div>
              </div>            
              <input type="password" class="form-control" name="password1" placeholder="Password" required>
            </div>
          </div>
          <div class="col-lg-12 mt-2">
            <div class="input-group mb-3">
              <div class="input-group-append">
                <div class="input-group-text" style="padding-right:12px;">
                  <span class="fas fa-lock"></span>
                </div>
              </div>            
              <input type="password" class="form-control" name="password2" placeholder="Ulangi Password" required>
            </div>
          </div>
        </div>
        <hr class="mt-3">
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-undo-alt mr-2"></i>Setel Ulang Password</button>
          </div>
        </div>
      </form>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>