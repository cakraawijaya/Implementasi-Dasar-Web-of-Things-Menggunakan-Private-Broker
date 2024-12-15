<?php
  if ($_SESSION['role'] != "Admin") {
    echo "<script> location.href = 'index.php'; </script>";
  }

  $page = $_GET['page'];
  $insert = false;
  $update = false;
  $delete = false;

  // Ubah data
  if (isset($_POST['edit_data'])) {
    $old_id = $_POST['edit_data'];
    $oldProfile = $_POST['oldProfile'];
    $username = preg_replace('~\P{L}+~u', '', strtolower($_POST['username']));
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $fullname = ucwords($_POST['fullname']);
    $gender = $_POST['gender'];
    $role = $_POST['role'];
    $active = $_POST['active'];  

    // Fungsi Edit Gambar
    if ($_FILES['profile']['error'] === 4) {
      $profile = $oldProfile;
    } else {
      $profile = upload_img();
      if (!$profile) {
        return false;
      }
    }
    
    if ($_POST['password'] == "") {
      $sql_edit = "UPDATE user SET username = '$username', email = '$email', gender = '$gender', fullname = '$fullname', profile = '$profile', role = '$role', active = '$active' WHERE username = '$old_id'";
    }
    else {
      $sql_edit = "UPDATE user SET username = '$username', password = '$password', email = '$email', gender = '$gender', fullname = '$fullname', profile = '$profile', role = '$role', active = '$active' WHERE username = '$old_id'";
    }

    mysqli_query($conn, $sql_edit);
    $update = true;
  }

  // Tambah data
  else if (isset($_POST['username'])) {
    $username = preg_replace('~\P{L}+~u', '', strtolower($_POST['username']));
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];
    $email = $_POST['email'];
    $fullname = ucwords($_POST['fullname']);
    $gender = $_POST['gender'];    
    $role = $_POST['role'];

    $select_username = "SELECT username FROM user WHERE username = '$username'";
    $select_email = "SELECT email FROM user WHERE email = '$email'";
    $check_username = mysqli_fetch_assoc(mysqli_query($conn, $select_username));
    $check_email = mysqli_fetch_assoc(mysqli_query($conn, $select_email));

    // Input username tidak boleh sama
    if ($check_username) {
      echo "<script>
        alert('Username sudah ada di database!');
        location.href = '?page=user';  
      </script>";
      return false;
    }    
    // Input email tidak boleh sama
    else if ($check_email) {
      echo "<script>
        alert('Email sudah ada di database!');
        location.href = '?page=user';
      </script>";
      return false;
    }
    else {
      // Fungsi Add Gambar
      if ($_FILES['profile']['error'] === 4) {
        $profile = "dist/img/default.jpg";
      } else {
        $profile = upload_img();
        if (!$profile) {
          return false;
        }
      }

      if ($password1 !== $password2) {
        echo "
        <script>
          alert('Password tidak sama!');
          location.href = '?page=user';
        </script>";
        return false;
      }
      else {
        $password = password_hash($_POST['password2'], PASSWORD_DEFAULT);
        $sql_insert = "INSERT INTO user (username, password, email, gender, fullname, profile, role) VALUES ('$username', '$password', '$email', '$gender', '$fullname', '$profile', '$role')";
        mysqli_query($conn, $sql_insert);
        $insert = true;
      }
    }
  }

  function upload_img() {
    $namaFile = $_FILES['profile']['name'];
    $ukuranFile = $_FILES['profile']['size'];
    $tmpName = $_FILES['profile']['tmp_name'];

    // Mengecek ekstensi gambar
    $ekstensiGambarDefault = ['jpg', 'jpeg', 'png'];
    $ekstensiGambarUpload = explode('.', $namaFile);
    $ekstensiGambarUpload = strtolower(end($ekstensiGambarUpload));

    if (!in_array($ekstensiGambarUpload, $ekstensiGambarDefault)) {
      echo "<script>
        alert('Yang anda upload bukan gambar!');
        location.href = '?page=user';
      </script>";
      return false;
    }

    // Cek Ukuran Gambar
    if ($ukuranFile > 2000000) {
      echo "<script>
        alert('Gambar yang anda upload melebihi 2mb!');
        location.href = '?page=user';
      </script>";
      return false;
    }

    // Lolos Pengecekan Gambar maka simpan gambar ke lokasi yang telah ditentukan
    $destination = 'dist/img/'.$namaFile;
    move_uploaded_file($tmpName, $destination);
    return $destination;
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
                    <td>
                      <?php 
                          if ($row['gender'] == "Undefined") {
                              echo "Tidak Dijelaskan"; 
                          } else {
                            echo $row['gender'];
                          }
                      ?>                         
                    </td>
                    <td><?php echo $row['role']; ?></td>
                    <td><?php echo $row['active']; ?></td>
                    <td style="text-align:center;">
                      <a href="?page=<?php echo $page ?>&edit=<?php echo $row['username']; ?>" class="btn btn-warning fas fa-edit"></a>
                      <a href="?page=<?php echo $page ?>&delete=<?php echo $row['username']; ?>" class="btn btn-danger fas fa-trash-alt"></a>
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
              <form method="POST" action="?page=<?php echo $page; ?>" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="row">           
                    <div class="col-lg-6">
                      <div class="input-group mb-2 mt-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text" style="padding-right:27px;"><i class="fas fa-file-signature" style="padding-right:7px;"></i>Nama Lengkap</div>
                        </div>
                        <input type="text" class="form-control" name="fullname" required>
                      </div>
                    </div>           
                    <div class="col-lg-6">
                      <div class="input-group mb-2 mt-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text" style="padding-right:32px;"><i class="fas fa-female mr-1"></i><i class="fas fa-male" style="padding-right:7px;"></i>Jenis Kelamin</div>
                        </div>
                        <select class="form-control" name="gender">
                          <option value="Undefined">Tidak Dijelaskan</option>
                          <option value="Pria">Pria</option>
                          <option value="Wanita">Wanita</option>
                        </select>
                      </div>
                    </div>     
                    <div class="col-lg-6 mt-4">
                      <span class="font-weight-light text-red"><strong>*Username tidak boleh sama!</strong></span>
                      <div class="input-group mb-2 mt-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text" style="padding-right:58px;"><i class="fas fa-user" style="padding-right:11px;"></i>Username</div>
                        </div>
                        <input type="text" class="form-control" name="username" required>
                      </div>
                    </div>   
                    <div class="col-lg-6 mt-4">
                      <span class="font-weight-light text-red"><strong>*Email tidak boleh sama!</strong></span>
                      <div class="input-group mb-2 mt-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text" style="padding-right:89px;"><i class="fas fa-envelope" style="padding-right:9px;"></i>Email</div>
                        </div>
                        <input type="email" class="form-control" name="email" required>
                      </div>
                    </div> 
                    <div class="col-lg-6 mt-2">
                      <div class="input-group mb-2 mt-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text" style="padding-right:62px;"><i class="fas fa-lock" style="padding-right:11px;"></i>Password</div>
                        </div>
                        <input type="password" class="form-control" name="password1" required>
                      </div>
                    </div>                 
                    <div class="col-lg-6 mt-2">
                      <div class="input-group mb-2 mt-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text" style="padding-right:15px;"><i class="fas fa-lock" style="padding-right:11px;"></i>Ulangi Password</div>
                        </div>
                        <input type="password" class="form-control" name="password2" required>
                      </div>
                    </div>    
                    <div class="col-lg-6 mt-2">
                      <div class="input-group mb-2 mt-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text" style="padding-right:58px;"><i class="fas fa-user-tag" style="padding-right:5px;"></i>Hak Akses</div>
                        </div>
                        <select class="custom-select form-control" name="role">
                          <option value="User">Pengguna</option>
                          <option value="Admin">Admin</option>
                        </select>
                      </div>
                    </div>                  
                    <div class="col-lg-6 mt-2">
                      <div class="input-group mb-2 mt-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text" style="padding-right:26px;"><i class="fas fa-images" style="padding-right:6px;"></i>Foto Pengguna</div>
                        </div>
                        <input type="file" class="form-control" name="profile">
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
              <form method="POST" action="?page=<?php echo $page; ?>" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="row">            
                    <div class="col-lg-6">
                      <div class="input-group mb-2 mt-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text" style="padding-right:12px;"><i class="fas fa-file-signature" style="padding-right:8px;"></i>Nama Lengkap</div>
                        </div>
                        <input type="text" class="form-control" name="fullname" value="<?php echo $data['fullname']; ?>" required>
                      </div>
                    </div>       
                    <div class="col-lg-6">
                      <div class="input-group mb-2 mt-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text" style="padding-right:44px;"><i class="fas fa-user" style="padding-right:11px;"></i>Username</div>
                        </div>                      
                        <input type="hidden" name="edit_data" value="<?php echo $data['username']; ?>">
                        <input type="text" class="form-control" name="username" value="<?php echo $data['username']; ?>" required>
                      </div>
                    </div>         
                    <div class="col-lg-6 mt-2">
                      <div class="input-group mb-2 mt-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text" style="padding-right:75px;"><i class="fas fa-envelope" style="padding-right:10px;"></i>Email</div>
                        </div>
                        <input type="email" class="form-control" name="email" value="<?php echo $data['email']; ?>" required>
                      </div>
                    </div>
                    <div class="col-lg-6 mt-2">
                      <div class="input-group mb-2 mt-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text" style="padding-right:18px;"><i class="fas fa-female mr-1"></i><i class="fas fa-male" style="padding-right:7px;"></i>Jenis Kelamin</div>
                        </div>
                        <select class="form-control" name="gender">
                          <?php if ($data['gender'] == "Wanita") { ?>
                            <option value="Wanita">Wanita</option>
                            <option value="Pria">Pria</option>
                            <option value="Undefined">Tidak Dijelaskan</option>
                          <?php } else if ($data['gender'] == "Undefined") { ?>
                            <option value="Undefined">Tidak Dijelaskan</option>
                            <option value="Pria">Pria</option>
                            <option value="Wanita">Wanita</option>
                          <?php } else { ?>
                            <option value="Pria">Pria</option>
                            <option value="Wanita">Wanita</option>
                            <option value="Undefined">Tidak Dijelaskan</option>
                          <?php } ?>
                        </select>
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
                    <div class="col-lg-6 mt-4">
                      <span class="font-weight-light text-red"><strong>*Upload File jika ingin mengubah Foto Pengguna!</strong></span>
                      <div class="input-group mb-2 mt-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text" style="padding-right:13px;"><i class="fas fa-images" style="padding-right:6px;"></i>Foto Pengguna</div>
                        </div>
                        <input type="hidden" name="oldProfile" value="<?php echo $data['profile']; ?>">
                        <input type="file" class="form-control" name="profile">
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