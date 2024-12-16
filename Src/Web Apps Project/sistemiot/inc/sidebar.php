<?php
  if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $sql = "SELECT * FROM user WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($result);
  }
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a class="brand-link">
    <span class="brand-text font-weight-light"><strong>Sistem IoT <i class="fas fa-laptop-house"></i></strong></span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <?php if (strlen($data['fullname']) <= 23 ) { ?>
        <div class="image">
          <img src="<?php echo $data['profile']; ?>" class="img-circle" alt="User Image" style="height:35px;max-height:auto;width:35px;max-width:auto;">
        </div>
      <?php } else { ?>
        <div class="image" style="padding-top:12px;">
          <img src="<?php echo $data['profile']; ?>" class="img-circle" alt="User Image" style="height:35px;max-height:auto;width:35px;max-width:auto;">
        </div>
      <?php } ?>
      
      <div class="info" style="white-space:normal;">
        <a href="?page=profile" class="d-block">
          <?php echo $data['fullname']; ?>
        </a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
              with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="?page=dashboard" class="nav-link">
            <i class="nav-icon fas fa-industry"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="?page=datasensor" class="nav-link">
            <i class="nav-icon fas fa-th"></i>
            <p>Data Sensor</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="?page=dataactuator" class="nav-link">
            <i class="nav-icon fas fa-th"></i>
            <p>Data Aktuator</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="?page=device" class="nav-link">
            <i class="nav-icon fas fa-laptop-code"></i>
            <p>Perangkat</p>
          </a>
        </li>
        <?php if ($_SESSION['role'] == "Admin") { ?>
        <li class="nav-item">
          <a href="?page=user" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>Pengguna</p>
          </a>
        </li>
        <?php } ?>
        <li class="nav-item">
          <a href="?page=iot_connection" class="nav-link">
            <i class="nav-icon fas fa-cloud"></i>
            <p>Koneksi IoT</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="logout.php" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Logout</p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>