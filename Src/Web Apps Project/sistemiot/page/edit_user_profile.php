<?php  
    if ($_SESSION['role'] != "User") {
        echo "<script> location.href = '?page=profile'; </script>";
    }
    
    $page = $_GET['page'];
    $update = false;

    // Edit Data Profil
    if (isset($_POST['edit_data'])) {
        $old_id = $_POST['edit_data'];
        $oldProfile = $_POST['oldProfile'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $email = $_POST['email'];
        $gender = $_POST['gender'];
        $fullname = ucwords($_POST['fullname']);

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
            $sql_edit = "UPDATE user SET email = '$email', gender = '$gender', fullname = '$fullname', profile = '$profile' WHERE username = '$old_id'";
        }
        else {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $sql_edit = "UPDATE user SET password = '$password', email = '$email', gender = '$gender', fullname = '$fullname', profile = '$profile' WHERE username = '$old_id'";
        }

        mysqli_query($conn, $sql_edit);
        $update = true;
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
?>

<?php if ($_SESSION['role'] == "User") { ?>
<div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <?php
                if ($update == true) {
                    alertType2("Data berhasil diperbarui", "<i class='fas fa-check'></i>");
                }
            ?>
            <div class="row">
                <div class="col-lg-12 p-4">
                    <div class="card card-dark">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-user-edit mr-2"></i>Ubah Profil</h3>
                        </div>

                        <!-- /.card-header -->
                        <form method="POST" action="?page=<?php echo $page; ?>" enctype="multipart/form-data">                                
                            <div class="card-body">
                                <div class="row">                              
                                    <div class="col-lg-6">
                                        <div class="input-group mb-2 mt-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text" style="padding-right:13px;"><i class="fas fa-file-signature" style="padding-right:7px;"></i>Nama Lengkap</div>
                                            </div>
                                            <input type="hidden" name="edit_data" value="<?php echo $data['username']; ?>">
                                            <input type="text" class="form-control" name="fullname" value="<?php echo $data['fullname']; ?>" required>
                                        </div>
                                    </div>     
                                    <div class="col-lg-6">
                                        <div class="input-group mb-2 mt-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text" style="padding-right:74px;"><i class="fas fa-envelope" style="padding-right:10px;"></i>Email</div>
                                            </div>
                                            <input type="email" class="form-control" name="email" value="<?php echo $data['email']; ?>" required>
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
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 mt-2">
                                        <div class="input-group mb-2 mt-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text" style="padding-right:19px;"><i class="fas fa-female mr-1"></i><i class="fas fa-male" style="padding-right:7px;"></i>Jenis Kelamin</div>
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
                                </div>
                            </div>

                            <div class="card-footer d-flex align-items-end flex-column">
                                <button type="submit" class="btn btn-dark fas fa-check-square" style="padding: 10px 60px 10px 60px;">&nbsp;&nbsp;Ubah</button>
                            </div>
                        </form>   
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php } ?>