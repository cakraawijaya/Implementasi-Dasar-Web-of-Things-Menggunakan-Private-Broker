<?php
  session_start();
  include "config/database.php";
  include "inc/alert.php";

  if (isset($_SESSION['username'])) {
    echo "<script> location.href = 'login.php'; </script>";
  }

  $register = false;
  $message = "Silakan Mendaftar di Form berikut";

  if (isset($_POST['username'])) {
    $username = preg_replace('~\P{L}+~u', '', strtolower($_POST['username']));
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];
    $fullname = ucwords($_POST['fullname']);
    $email = $_POST['email'];

    if (strlen($username) > 10) {
      echo "
      <script>
        alert('Username tidak boleh melebihi 10 kata!');
        location.href = '?page=user';
      </script>";
      return false;
    }

    $select_username = "SELECT username FROM user WHERE username = '$username'";
    $select_email = "SELECT email FROM user WHERE email = '$email'";
    $check_username = mysqli_fetch_assoc(mysqli_query($conn, $select_username));
    $check_email = mysqli_fetch_assoc(mysqli_query($conn, $select_email));

    // Input username tidak boleh sama
    if ($check_username) {
      echo "<script>
        alert('Username sudah ada di database!');
        location.href = 'register.php';
      </script>";
      return false;
    }    
    // Input email tidak boleh sama
    else if ($check_email) {
      echo "<script>
        alert('Email sudah ada di database!');
        location.href = 'register.php';
      </script>";
      return false;
    }
    else {
      if ($password1 !== $password2) {
        $message = "<b style='color:red;'><i class='fas fa-exclamation-triangle'></i> Password tidak sama!</b>";
      }
      else {
        $password = password_hash($_POST['password2'], PASSWORD_DEFAULT);
        $sql_registration = "INSERT INTO user (username, password, email, fullname) VALUES ('$username', '$password', '$email', '$fullname')";
        mysqli_query($conn, $sql_registration);
        $register = true;
      }
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistem IoT | Registrasi</title>

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
<div class="register-box" style="width:50%;">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <h1><b>Sistem</b> IoT</h1>
    </div>
    
    <form action="" method="POST">
      <div class="card-body">
        <p class="login-box-msg">
          <?php 
            echo $message;
            
            if ($register == true) {
              alertType1("Data berhasil didaftarkan", "<i class='fas fa-check'></i>");
            } 
          ?>
        </p>

        <div class="row">    
          <div class="col-lg-12">
            <div class="input-group mb-3">
              <div class="input-group-append">
                <div class="input-group-text" style="padding-right:8px;">
                  <span class="fas fa-file-signature"></span>
                </div>
              </div>            
              <input type="text" class="form-control" name="fullname" placeholder="Nama Lengkap" required>
            </div>
          </div>    
          <div class="col-lg-6 mt-2">
            <div class="input-group mb-3">
              <div class="input-group-append">
                <div class="input-group-text" style="padding-right:12px;">
                  <span class="fas fa-user"></span>
                </div>
              </div>            
              <input type="text" class="form-control" name="username" placeholder="Username" required>
            </div>
          </div>
          <div class="col-lg-6 mt-2">
            <div class="input-group mb-3">
              <div class="input-group-append">
                <div class="input-group-text" style="padding-right:10px;">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>            
              <input type="email" class="form-control" name="email" placeholder="Email" required>
            </div>
          </div>    
          <div class="col-lg-6 mt-2">
            <div class="input-group mb-3">
              <div class="input-group-append">
                <div class="input-group-text" style="padding-right:12px;">
                  <span class="fas fa-lock"></span>
                </div>
              </div>            
              <input type="password" class="form-control" name="password1" placeholder="Password" required>
            </div>
          </div>
          <div class="col-lg-6 mt-2">
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
          <div class="col-8 mt-2">
            Sudah punya akun?<a href="login.php" class="text-center"> Login</a>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-user-plus mr-2"></i>Daftar</button>
          </div>
          <!-- /.col -->
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
