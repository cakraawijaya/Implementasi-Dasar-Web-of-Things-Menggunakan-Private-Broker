<?php  
    if ($_SESSION['role'] != "User") {
        echo "<script> location.href = '?page=profile'; </script>";
    }

    $page = $_GET['page'];
    $update = false;

    // Edit Data Profil
    // --->> di bagian ini ada yang bermasalah
    if (isset($_POST['edit_dataProfile'])) {
        $old_id = $_POST['edit_dataProfile'];
        $editUsername = $_POST['username'];
        $editPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $editGender = $_POST['gender'];
        $editFullname = $_POST['fullname'];

        $sql_editProfile = "UPDATE user SET username = '$editUsername', password = '$editPassword', gender = '$editGender', fullname = '$editFullname' WHERE username = '$old_id'";
        mysqli_query($conn, $sql_editProfile);
        $update = true;
        echo "<script> location.href = '?page=profile'; </script>";
    }
?>

<?php if ($_SESSION['role'] == "User") { ?>
<div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <?php
                if ($update == true) {
                alertType2("Data berhasil diperbarui");
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
                            <form class="row g-2" method="POST" action="?page=<?php echo $page; ?>">
                                <div class="col-md-4 mt-2">
                                    <label><i class="fas fa-file-signature mr-2"></i>Nama Lengkap</label>
                                    <p class="font-weight-light text-red"><strong>*Silakan abaikan jika tidak ingin mengubah!</strong></p>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="fullname" value="<?php echo $_SESSION['fullname']; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <label><i class="fas fa-user mr-2"></i>Username</label>
                                    <p class="font-weight-light text-red"><strong>*Username tidak boleh sama!</strong></p>
                                    <div class="input-group">
                                        <input type="hidden" name="edit_dataProfile" value="<?php echo $data['username']; ?>">
                                        <input type="text" class="form-control" name="username" value="<?php echo $_SESSION['username']; ?>" required>
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