<?php
  if ($_SESSION['role'] != "Admin") {
    echo "<script> location.href = 'index.php' </script>";
  }

  $page = $_GET['page'];
  $insert = false;
  $update = false;
  $delete = false;

  // Ubah data
  if (isset($_POST['edit_data'])) {
    $old_id = $_POST['edit_data'];
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $gender = $_POST['gender'];
    $role = $_POST['role'];
    $active = $_POST['active'];

    if ($_POST['password'] == "") {
      $sql_edit = "UPDATE user SET username = '$username', gender = '$gender', fullname = '$fullname', role = '$role', active = '$active' WHERE username = '$old_id'";
    }
    else {
      $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
      $sql_edit = "UPDATE user SET username = '$username', password = '$password', gender = '$gender', fullname = '$fullname', role = '$role', active = '$active' WHERE username = '$old_id'";
    }

    mysqli_query($conn, $sql_edit);
    $update = true;
  }

  // Tambah data
  else if (isset($_POST['username'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $fullname = $_POST['fullname'];
    $gender = $_POST['gender'];
    $role = $_POST['role'];

    $sql_insert = "INSERT INTO user (username, password, gender, fullname, role) VALUES ('$username', '$password', '$gender', '$fullname', '$role')";
    mysqli_query($conn, $sql_insert);
    $insert = true;
  }

  // Mengambil id untuk Edit
  if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $sql_select_data = "SELECT * FROM user WHERE username = '$id' LIMIT 1";
    $result = mysqli_query($conn, $sql_select_data);
    $data = mysqli_fetch_assoc($result);
  }

  // Mengambil id untuk Delete
  if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql_delete_data = "DELETE FROM user WHERE username = '$id' LIMIT 1";
    mysqli_query($conn, $sql_delete_data);
    $delete = true;
  }

  // Baca Tabel user
  $sql = "SELECT * FROM user";
  $result = mysqli_query($conn, $sql);
?>

<div class="content-wrapper">
  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <?php
        if ($insert == true) {
          alertSuccess("Data berhasil ditambahkan");
        }

        if ($update == true) {
          alertUpdate("Data berhasil diperbarui");
        }

        if ($delete == true) {
          alertDelete("Data berhasil dihapus");
        }
      ?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card card-dark mt-4">
            <div class="card-header">
              <h3 class="card-title"><i class="nav-icon fas fa-users mr-2"></i>Pengguna Yang Terdaftar</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Username</th>
                    <th>Nama Lengkap</th>
                    <th>Jenis Kelamin</th>
                    <th>Hak Akses</th>
                    <th>Aktif (?)</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while($row = mysqli_fetch_assoc($result)){ ?>
                  <tr>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['fullname']; ?></td>
                    <td><?php echo $row['gender']; ?></td>
                    <td><?php echo $row['role']; ?></td>
                    <td><?php echo $row['active']; ?></td>
                    <td style="text-align:center;">
                      <a href="?page=<?php echo $page ?>&edit=<?php echo $row['username'] ?>" class="btn btn-warning fas fa-edit"></a>
                      <a href="?page=<?php echo $page ?>&delete=<?php echo $row['username'] ?>" class="btn btn-danger fas fa-trash-alt"></a>
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
                <h3 class="card-title"><i class="fas fa-user-plus mr-2"></i>Tambah Data</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" action="?page=<?php echo $page; ?>">
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-6">
                      <span class="font-weight-light text-red"><strong>*Username tidak boleh sama!</strong></span>
                      <div class="input-group mb-2 mt-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text" style="padding-right:44px;"><i class="fas fa-user" style="padding-right:11px;"></i>Username</div>
                        </div>
                        <input type="text" class="form-control" name="username" required>
                      </div>
                    </div>
                    <div class="col-lg-6 mt-4">
                      <div class="input-group mb-2 mt-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text" style="padding-right:48px;"><i class="fas fa-lock" style="padding-right:11px;"></i>Password</div>
                        </div>
                        <input type="password" class="form-control" name="password" required>
                      </div>
                    </div>
                    <div class="col-lg-6 mt-2">
                      <div class="input-group mb-2 mt-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text" style="padding-right:12px;"><i class="fas fa-file-signature" style="padding-right:7px;"></i>Nama Lengkap</div>
                        </div>
                        <input type="text" class="form-control" name="fullname" required>
                      </div>
                    </div>                  
                    <div class="col-lg-6 mt-2">
                      <div class="input-group mb-2 mt-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text" style="padding-right:44px;"><i class="fas fa-user-tag" style="padding-right:5px;"></i>Hak Akses</div>
                        </div>
                        <select class="custom-select form-control" name="role">
                            <option value="Admin">Admin</option>
                            <option value="User">Pengguna</option>
                        </select>
                      </div>
                    </div>                
                    <div class="col-lg-6">
                      <div class="input-group mb-2 mt-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text" style="padding-right:18px;"><i class="fas fa-female mr-1"></i><i class="fas fa-male" style="padding-right:7px;"></i>Jenis Kelamin</div>
                        </div>
                        <select class="form-control" name="gender">
                            <option value="Pria">Pria</option>
                            <option value="Wanita">Wanita</option>
                        </select>
                      </div>
                    </div>                    
                    <div class="col-lg-6">
                      <div class="input-group mb-2 mt-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text" style="padding-right:13px;"><i class="fas fa-images" style="padding-right:6px;"></i>Foto Pengguna</div>
                        </div>
                        <input type="file" class="form-control" name="profile">
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
                      <div class="input-group mb-2 mt-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text" style="padding-right:12px;"><i class="fas fa-file-signature" style="padding-right:7px;"></i>Nama Lengkap</div>
                        </div>
                        <input type="text" class="form-control" name="fullname" value="<?php echo $data['fullname']; ?>" required>
                      </div>
                    </div>            
                    <div class="col-lg-6">
                      <div class="input-group mb-2 mt-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text" style="padding-right:18px;"><i class="fas fa-female mr-1"></i><i class="fas fa-male" style="padding-right:7px;"></i>Jenis Kelamin</div>
                        </div>
                        <select class="form-control" name="gender">
                          <?php if ($data['gender'] == "Wanita"){ ?>
                            <option value="Wanita">Wanita</option>
                            <option value="Pria">Pria</option>
                          <?php } else { ?>
                            <option value="Pria">Pria</option>
                            <option value="Wanita">Wanita</option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-6 mt-4">
                      <span class="font-weight-light text-red"><strong>*Jika ingin mengubah, Username tidak boleh sama!</strong></span>
                      <div class="input-group mb-2 mt-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text" style="padding-right:44px;"><i class="fas fa-user" style="padding-right:11px;"></i>Username</div>
                        </div>                      
                        <input type="hidden" name="edit_data" value="<?php echo $data['username']; ?>">
                        <input type="text" class="form-control" name="username" value="<?php echo $data['username']; ?>" required>
                      </div>
                    </div>
                    <div class="col-lg-6 mt-4">
                      <span class="font-weight-light text-red"><strong>*Isi jika ingin mengubah Password!</strong></span>
                      <div class="input-group mb-2 mt-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text" style="padding-right:48px;"><i class="fas fa-lock" style="padding-right:11px;"></i>Password</div>
                        </div>
                        <input type="password" class="form-control" name="password">
                      </div>
                    </div>  
                    <div class="col-lg-6 mt-2">
                      <div class="input-group mb-2 mt-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text" style="padding-right:44px;"><i class="fas fa-user-tag" style="padding-right:5px;"></i>Hak Akses</div>
                        </div>
                        <select class="form-control" name="role">
                          <?php if ($data['role'] == "Admin"){ ?>
                            <option value="Admin">Admin</option>
                            <option value="User">Pengguna</option>
                          <?php } else { ?>
                            <option value="User">Pengguna</option>
                            <option value="Admin">Admin</option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-6 mt-2">
                      <div class="input-group mb-2 mt-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text" style="padding-right:68px;"><i class="fas fa-eye mr-2"></i>Status</div>
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
                    <div class="col-lg-6 mt-4">
                      <span class="font-weight-light text-red"><strong>*Upload File jika ingin mengubah Foto Pengguna!</strong></span>
                      <div class="input-group mb-2 mt-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text" style="padding-right:13px;"><i class="fas fa-images" style="padding-right:6px;"></i>Foto Pengguna</div>
                        </div>
                        <input type="file" class="form-control" name="profile">
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