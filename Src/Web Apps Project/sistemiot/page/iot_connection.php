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
    
    $sql_edit = "UPDATE iot_connection SET serial_number = '$serial_number', server_name = '$server_name', port = '$port', username_account = $username_account, password_account = '$password_account' WHERE serial_number = '$old_id'";
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
    $sql_select_data = "SELECT * FROM iot_connection WHERE serial_number = '$id' LIMIT 1";
    $result = mysqli_query($conn, $sql_select_data);
    $data = mysqli_fetch_assoc($result);
  }

  // Mengambil id untuk Delete
  if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql_delete_data = "DELETE FROM iot_connection WHERE serial_number = '$id' LIMIT 1";
    mysqli_query($conn, $sql_delete_data);
    $delete = true;
  }

  // Baca Tabel user
  $sql = "SELECT * FROM iot_connection";
  $result = mysqli_query($conn, $sql);
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
                    <td><?php echo $row['serial_number']; ?></td>
                    <td><?php echo $row['port']; ?></td>
                    <td><?php echo $row['username_account']; ?></td>
                    <td><?php echo $row['password_account']; ?></td>
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