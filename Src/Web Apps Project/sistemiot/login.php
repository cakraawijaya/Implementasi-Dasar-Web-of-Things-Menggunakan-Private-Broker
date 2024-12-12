<?php
    session_start();
    include "config/database.php";

    $message = "Masukkan Username dan Password";

    if (isset($_POST['username'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM user WHERE username = '$username' LIMIT 1";
        $result = mysqli_query($conn, $sql);

        $data = mysqli_fetch_assoc($result);

        if (!mysqli_num_rows($result) > 0) {
            $message = "<b style='color:red;'><i class='fas fa-exclamation-triangle'></i> Username tidak terdaftar!</b>";
        }
        else {
            if (password_verify($password, $data['password'])) {
                $_SESSION['username'] = $username;
                $_SESSION['password'] = $password;
                $_SESSION['fullname'] = $data['fullname'];
                $_SESSION['gender'] = $data['gender'];
                $_SESSION['profile'] = $data['profile'];
                $_SESSION['role'] = $data['role'];

                echo "<script> location.href = 'index.php' </script>";
            }
            else {
                $message = "<b style='color:red;'><i class='fas fa-exclamation-triangle'></i> Password salah!</b>";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistem IoT | Login</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <h1><b>Sistem</b> IoT</h1>
    </div>
    <div class="card-body">
      <p class="login-box-msg"><?php echo $message; ?></p>

      <form action="" method="POST">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="username" placeholder="Username" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-6 d-flex align-items-start flex-column">
            <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-sign-in-alt mr-2"></i>Masuk</button>
          </div>
          <!-- /.col -->
          <div class="col-6 d-flex align-items-end flex-column">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Ingat Saya
              </label>
            </div>
          </div>
        </div>
      </form>

      <p class="mt-4 mb-1"><hr>
        <a href="forgot-password.php">Lupa Password</a>
      </p>
      <p class="mb-0">
        Belum Punya Akun? 
        <a href="register.php" class="text-center">Daftar</a>
      </p>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
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