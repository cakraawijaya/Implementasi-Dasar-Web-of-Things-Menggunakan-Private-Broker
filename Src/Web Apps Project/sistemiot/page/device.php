<?php
  $page = $_GET['page'];
  $insert = false;
  $update = false;
  $delete = false;

  // Ubah data
  if (isset($_POST['edit_data'])) {
    $old_id = $_POST['edit_data'];
    $serial_number = $_POST['serial_number'];
    $controller_type = $_POST['controller'];
    $location = $_POST['location'];
    $active = $_POST['active'];

    $sql_edit = "UPDATE devices SET serial_number = '$serial_number', mcu_type = '$controller_type', location = '$location', active = '$active' WHERE serial_number = '$old_id'";
    mysqli_query($conn, $sql_edit);
    $update = true;
  }

  // Tambah data
  else if (isset($_POST['serial_number'])) {
    $serial_number = $_POST['serial_number'];
    $username = $_POST['username'];
    $controller_type = $_POST['controller'];
    $location = $_POST['location'];

    $select_serialNumber = "SELECT serial_number FROM devices WHERE serial_number = '$serial_number'";
    $check_serialNumber = mysqli_fetch_assoc(mysqli_query($conn, $select_serialNumber));

    // Input serial number tidak boleh sama
    if ($check_serialNumber) {
      echo "<script>
        alert('Serial Number sudah ada di database!');
        location.href = '?page=device';  
      </script>";
      return false;
    }
    else {
      $sql_insert = "INSERT INTO devices (serial_number, username, mcu_type, location) VALUES ('$serial_number', '$username', '$controller_type', '$location')";
      mysqli_query($conn, $sql_insert);
      $insert = true;
    }
  }

  // Mengambil id untuk Edit
  if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $username = $_SESSION['username'];
    $sql_select_data = "SELECT * FROM devices WHERE serial_number = '$id' AND username = '$username' LIMIT 1";
    $result = mysqli_query($conn, $sql_select_data);
    $data = mysqli_fetch_assoc($result);
  }

  // Mengambil id untuk Delete
  if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $username = $_SESSION['username'];
    $sql_delete_data = "DELETE FROM devices WHERE serial_number = '$id' AND username = '$username' LIMIT 1";
    mysqli_query($conn, $sql_delete_data);
    $delete = true;
  }

  // Baca Tabel devices
  if ($_SESSION['username'] > 0) {
    $username = $_SESSION['username'];
    $sql = "SELECT * FROM devices WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
  }
?>

<div class="content-wrapper">
  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <?php
        if ($insert == true) {
          alertType1("Data berhasil ditambahkan");
        }

        if ($update == true) {
          alertType2("Data berhasil diperbarui");
        }

        if ($delete == true) {
          alertType3("Data berhasil dihapus");
        }
      ?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card card-dark mt-4">
            <div class="card-header">
              <h3 class="card-title"><i class="nav-icon fas fa-laptop-code mr-2"></i>Perangkat Yang Terdaftar</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Serial Number</th>
                    <th>Tipe Kontroler</th>
                    <th>Lokasi</th>
                    <th>Waktu Didaftarkan</th>
                    <th>Aktif (?)</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while($row = mysqli_fetch_assoc($result)){ ?>
                  <tr>
                    <td><?php echo $row['serial_number']; ?></td>
                    <td><?php echo $row['mcu_type']; ?></td>
                    <td><?php echo $row['location']; ?></td>
                    <td><?php echo $row['created_time']; ?></td>
                    <td><?php echo $row['active']; ?></td>
                    <td style="text-align:center;">
                      <a href="?page=<?php echo $page ?>&edit=<?php echo $row['serial_number']; ?>" class="btn btn-warning fas fa-edit"></a>
                      <a href="?page=<?php echo $page ?>&delete=<?php echo $row['serial_number']; ?>" class="btn btn-danger fas fa-trash-alt"></a>
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div><br>

          <?php if (!isset($_GET['edit'])) { ?>

            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"><i class="fas fa-plus-square mr-2"></i>Tambah Data</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" action="?page=<?php echo $page; ?>">
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-4">
                      <span class="font-weight-light text-red"><strong>*Serial number tidak boleh sama!</strong></span>
                      <div class="input-group mb-2 mt-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text" style="padding-right:9px;"><i class="fas fa-tags mr-2"></i>Serial Number</div>
                        </div>
                        <input type="hidden" name="username" value="<?php echo $_SESSION['username']; ?>">
                        <input type="text" class="form-control" name="serial_number" required>
                      </div>
                    </div>
                    <div class="col-lg-4 mt-4">
                      <div class="input-group mb-2 mt-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text" style="padding-right:11px;"><i class="fas fa-hdd mr-2"></i>Tipe Kontroler</div>
                        </div>
                        <input type="text" class="form-control" name="controller" required>
                      </div>
                    </div>                  
                    <div class="col-lg-4 mt-4">
                      <div class="input-group mb-2 mt-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text" style="padding-right:70px;"><i class="fas fa-map-marker-alt mr-2"></i>Lokasi</div>
                        </div>
                        <input type="text" class="form-control" name="location" required>
                      </div>
                    </div>         
                  </div>     
                </div>
                <!-- /.card-body -->

                <div class="card-footer d-flex align-items-end flex-column">
                  <button type="submit" class="btn btn-primary fas fa-check-square px-4"> Tambah</button>
                </div>
              </form>
            </div>

          <?php } else { ?>

            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title"><i class="fas fa-edit mr-2"></i>Ubah Data</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" action="?page=<?php echo $page; ?>">
                <div class="card-body">
                  <div class="row">                    
                    <div class="col-lg-6">
                      <span class="font-weight-light text-red"><strong>*Silakan abaikan jika tidak ingin mengubah!</strong></span>
                      <div class="input-group mb-2 mt-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text" style="padding-right:9px;"><i class="fas fa-tags mr-2"></i>Serial Number</div>
                        </div>
                        <input type="hidden" name="edit_data" value="<?php echo $data['serial_number']; ?>">
                        <input type="text" class="form-control" name="serial_number" value="<?php echo $data['serial_number']; ?>" required>
                      </div>
                    </div>
                    <div class="col-lg-6 mt-4">
                      <div class="input-group mb-2 mt-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text" style="padding-right:11px;"><i class="fas fa-hdd mr-2"></i>Tipe Kontroler</div>
                        </div>
                        <input type="text" class="form-control" name="controller" value="<?php echo $data['mcu_type']; ?>" required>
                      </div>
                    </div>
                    <div class="col-lg-6 mt-2">
                      <div class="input-group mb-2 mt-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text" style="padding-right:70px;"><i class="fas fa-map-marker-alt mr-2"></i>Lokasi</div>
                        </div>
                        <input type="text" class="form-control" name="location" value="<?php echo $data['location']; ?>" required>
                      </div>
                    </div>
                    <div class="col-lg-6 mt-2">
                      <div class="input-group mb-2 mt-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text" style="padding-right:65px;"><i class="fas fa-eye mr-2"></i>Status</div>
                        </div>
                        <select class="form-control" name="active">
                          <?php if ($data['active'] == "Yes"){ ?>
                            <option value="Yes">Aktif</option>
                            <option value="No">Tidak Aktif</option>
                          <?php } else { ?>
                            <option value="No">Tidak Aktif</option>
                            <option value="Yes">Aktif</option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>                  
                </div>                      
                <!-- /.card-body -->

                <div class="card-footer d-flex align-items-end flex-column">
                  <button type="submit" class="btn btn-warning fas fa-check-square px-4"> Ubah</button>
                </div>
              </form>
            </div>

          <?php } ?>
          
        </div>
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content -->
</div>