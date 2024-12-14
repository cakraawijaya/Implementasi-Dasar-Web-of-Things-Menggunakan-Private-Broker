<?php
  if ($_SESSION['active'] == "No") {
    session_destroy();
    echo "<script> location.href = 'login.php'; </script>";
  }

  // Baca Tabel Sensor
  if ($_SESSION['username'] > 0) {
    $username = $_SESSION['username'];
    $sql = "SELECT * FROM data WHERE username = '$username' AND sensor_actuator = 'sensor'";
    $result = mysqli_query($conn, $sql);
  }
?>

<div class="content-wrapper">
  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card card-dark mt-4">
            <div class="card-header">
              <h3 class="card-title"><i class="nav-icon fas fa-th mr-2"></i>Riwayat Data Sensor</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Serial Number</th>
                    <th>Name</th>
                    <th>Nilai</th>
                    <th>Topic</th>
                    <th>Waktu</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while($row = mysqli_fetch_assoc($result)){ ?>
                  <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['serial_number']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['value']; ?></td>
                    <td><?php echo $row['mqtt_topic']; ?></td>
                    <td><?php echo $row['time']; ?></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
        </div>
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content -->
</div>