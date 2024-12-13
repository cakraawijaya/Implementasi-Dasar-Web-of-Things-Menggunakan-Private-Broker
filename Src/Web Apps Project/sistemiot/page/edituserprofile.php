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
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $gender = $_POST['gender'];
        $fullname = $_POST['fullname'];

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
            $sql_edit = "UPDATE user SET username = '$username', gender = '$gender', fullname = '$fullname', profile = '$profile' WHERE username = '$old_id'";
        }
        else {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $sql_edit = "UPDATE user SET username = '$username', password = '$password', gender = '$gender', fullname = '$fullname', profile = '$profile' WHERE username = '$old_id'";
        }

        mysqli_query($conn, $sql_edit);
        $update = true;
        echo "
        <script>
            setInterval(function(){
                location.href = '?page=profile';
            }, 15000);
        </script>";
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
                    alertType2("<strong><p>Data berhasil diperbarui...</p></strong><span class='font-weight-dark'>Silakan logout terlebih dahulu untuk melihat pembaruan tampilan profil</span>");
                }
            ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-dark mt-4">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-user-edit mr-2"></i>Ubah Profil</h3>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body">
                            <form class="row g-2" method="POST" action="?page=<?php echo $page; ?>" enctype="multipart/form-data">                                
                                <div class="col-md-4 mt-2">
                                    <label><i class="fas fa-user mr-2"></i>Username</label>
                                    <p class="font-weight-light text-red"><strong>*Username tidak boleh sama!</strong></p>
                                    <div class="input-group">
                                        <input type="hidden" name="edit_data" value="<?php echo $_SESSION['username']; ?>">
                                        <input type="text" class="form-control" name="username" value="<?php echo $_SESSION['username']; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <label><i class="fas fa-file-signature mr-2"></i>Nama Lengkap</label>
                                    <p class="font-weight-light text-red"><strong>*Silakan abaikan jika tidak ingin mengubah!</strong></p>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="fullname" value="<?php echo $_SESSION['fullname']; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <label><i class="fas fa-lock mr-2"></i>Password</label>
                                    <p class="font-weight-light text-red"><strong>*Silakan abaikan jika tidak ingin mengubah!</strong></p>
                                    <div class="input-group">
                                        <button onclick="showPass()" class="btn btn-outline-secondary fas fa-eye" type="button"></button>
                                        <input type="password" class="form-control" name="password" value="<?php echo $_SESSION['password']; ?>" id="passwordProfile">
                                    </div>
                                </div>
                                <div class="col-md-6 mt-4">
                                    <label><i class="fas fa-female mr-1"></i><i class="fas fa-male mr-2"></i>Jenis Kelamin</label>
                                    <p class="font-weight-light text-red"><strong>*Silakan abaikan jika tidak ingin mengubah!</strong></p>
                                    <div class="input-group">
                                        <select class="form-control" name="gender">
                                        <?php if ($_SESSION['gender'] == "Wanita") { ?>
                                            <option value="Wanita">Wanita</option>
                                            <option value="Pria">Pria</option>
                                            <option value="Undefined">Tidak Dijelaskan</option>
                                        <?php } else if ($_SESSION['gender'] == "Undefined") { ?>
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
                                <div class="col-md-6 mt-4">
                                    <label><i class="fas fa-images mr-2"></i>Foto Pengguna</label>
                                    <p class="font-weight-light text-red"><strong>*Upload File jika ingin mengubah Foto Pengguna!</strong></p>
                                    <div class="input-group">
                                        <input type="hidden" name="oldProfile" value="<?php echo $_SESSION['profile']; ?>">
                                        <input type="file" class="form-control" name="profile">
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer d-flex align-items-end flex-column">
                                <button type="submit" class="btn btn-dark fas fa-check-square px-4"> Ubah</button>
                            </div>
                        </form>   
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showPass() {
        var x = document.getElementById("passwordProfile");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>

<?php } ?>