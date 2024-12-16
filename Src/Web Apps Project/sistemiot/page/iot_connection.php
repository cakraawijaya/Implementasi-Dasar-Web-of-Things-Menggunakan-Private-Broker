<?php
  $page = $_GET['page'];
  $insert = false;
  $update = false;
  $delete = false;

  // Ubah data
  if (isset($_POST['edit_data'])) {
    $old_id = $_POST['edit_data'];
    $serial_number = $_POST['serial_number'];
    $server_name = $_POST['server_name'];
    $port = $_POST['port'];
    $username_account = $_POST['username_account'];
    $password_account = $_POST['password_account'];
    
    $sql_edit = "UPDATE iot_connection SET serial_number = '$serial_number', server_name = '$server_name', port = '$port', username_account = '$username_account', password_account = '$password_account' WHERE id = '$old_id'";
    mysqli_query($conn, $sql_edit);
    $update = true;
  }

  // Tambah data
  else if (isset($_POST['serial_number'])) {
    $serial_number = $_POST['serial_number'];
    $server_name = $_POST['server_name'];
    $port = $_POST['port'];
    $username_account = $_POST['username_account'];
    $password_account = $_POST['password_account'];

    $sql_insert = "INSERT INTO iot_connection (serial_number, server_name, port, username_account, password_account) VALUES ('$serial_number', '$server_name', '$port', '$username_account', '$password_account')";
    mysqli_query($conn, $sql_insert);
    $insert = true;
  }

  // Mengambil id untuk Edit
  if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $sql_select_data = "SELECT * FROM iot_connection WHERE id = '$id' LIMIT 1";
    $edit = mysqli_query($conn, $sql_select_data);
    $data = mysqli_fetch_assoc($edit);
  }

  // Mengambil id untuk Delete
  if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql_delete_data = "DELETE FROM iot_connection WHERE id = '$id' LIMIT 1";
    mysqli_query($conn, $sql_delete_data);
    $delete = true;
  }

  if ($_SESSION['username'] > 0) {
    $username = $_SESSION['username'];
    $select_serialNumber = mysqli_fetch_assoc(mysqli_query($conn, "SELECT serial_number FROM devices WHERE username = '$username' LIMIT 1"));
    $serial_number = implode(" ", $select_serialNumber);
    $result = mysqli_query($conn, "SELECT * FROM iot_connection WHERE serial_number = '$serial_number'");
  }
?>

<div class="content-wrapper">
  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <?php
        if ($insert == true) {
          alertType1("Data berhasil ditambahkan", "<i class='fas fa-check'></i>");
        }

        if ($update == true) {
          alertType2("Data berhasil diperbarui", "<i class='fas fa-check'></i>");
        }

        if ($delete == true) {
          alertType3("Data berhasil dihapus", "<i class='fas fa-check'></i>");
        }
      ?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card card-dark mt-4">
            <div class="card-header">
              <h3 class="card-title"><i class="nav-icon fas fa-cloud mr-2"></i>Koneksi IoT Yang Dibuat</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Nama Server</th>
                    <th>Port</th>
                    <th>Nama Pengguna Akun</th>
                    <th>Password Pengguna Akun</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while($row = mysqli_fetch_assoc($result)){ ?>
                  <tr>
                    <td><?php echo $row['server_name']; ?></td>
                    <td><?php echo $row['port']; ?></td>
                    <td><?php echo $row['username_account']; ?></td>
                    <td><?php echo $row['password_account']; ?></td>
                    <td style="text-align:center;">
                      <a href="?page=<?php echo $page ?>&edit=<?php echo $row['id']; ?>" class="btn btn-warning fas fa-edit"></a>
                      <a href="?page=<?php echo $page ?>&delete=<?php echo $row['id']; ?>" class="btn btn-danger fas fa-trash-alt"></a>
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
                    <div class="col-lg-12">
                      <div class="input-group mb-2 mt-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text" style="padding-right:38px;"><i class="fas fa-wifi mr-2"></i>Server</div>
                        </div>
                        <input type="hidden" name="serial_number" value="<?php echo $serial_number; ?>">
                        <input type="text" class="form-control" name="server_name" required>
                        <input type="hidden" name="port" class="form-control" value="443">
                      </div>
                    </div>              
                    <div class="col-lg-12">
                      <div class="input-group mb-2 mt-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text" style="padding-right:13px;"><i class="fas fa-user mr-2" style="padding-right:6px;"></i>Username</div>
                        </div>
                        <input type="text" class="form-control" name="username_account" required>
                      </div>
                    </div>                   
                    <div class="col-lg-12">
                      <div class="input-group mb-2 mt-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text" style="padding-right:18px;"><i class="fas fa-lock mr-2" style="padding-right:5px;"></i>Password</div>
                        </div>
                        <input type="text" class="form-control" name="password_account" required>
                      </div>
                    </div>         
                  </div>     
                </div>
                <!-- /.card-body -->

                <div class="card-footer d-flex align-items-end flex-column">
                  <button type="submit" class="btn btn-primary fas fa-check-square" style="padding: 10px 60px 10px 60px;">&nbsp;&nbsp;Tambah</button>
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
                    <div class="col-lg-12">
                      <div class="input-group mb-2 mt-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text" style="padding-right:38px;"><i class="fas fa-wifi mr-2"></i>Server</div>
                        </div>
                        <input type="hidden" name="edit_data" value="<?php echo $data['id']; ?>">
                        <input type="hidden" name="serial_number" value="<?php echo $data['serial_number']; ?>">
                        <input type="text" class="form-control" name="server_name" value="<?php echo $data['server_name']; ?>" required>
                        <input type="hidden" name="port" class="form-control" value="<?php echo $data['port']; ?>">
                      </div>
                    </div>              
                    <div class="col-lg-12">
                      <div class="input-group mb-2 mt-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text" style="padding-right:13px;"><i class="fas fa-user mr-2" style="padding-right:6px;"></i>Username</div>
                        </div>
                        <input type="text" class="form-control" name="username_account" value="<?php echo $data['username_account']; ?>" required>
                      </div>
                    </div>                   
                    <div class="col-lg-12">
                      <div class="input-group mb-2 mt-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text" style="padding-right:18px;"><i class="fas fa-lock mr-2" style="padding-right:5px;"></i>Password</div>
                        </div>
                        <input type="text" class="form-control" name="password_account" value="<?php echo $data['password_account']; ?>" required>
                      </div>
                    </div> 
                  </div>                  
                </div>                      
                <!-- /.card-body -->

                <div class="card-footer d-flex align-items-end flex-column">
                  <button type="submit" class="btn btn-warning fas fa-check-square" style="padding: 10px 60px 10px 60px;">&nbsp;&nbsp;Ubah</button>
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