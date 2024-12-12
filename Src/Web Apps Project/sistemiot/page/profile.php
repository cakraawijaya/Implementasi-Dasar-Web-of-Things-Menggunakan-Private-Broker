<?php  
    $page = $_GET['page'];
    $update = false;

    // Ada Masalah Disini
    if (isset($_POST['edit_dataProfile'])) {
        $old_id = $_POST['edit_dataProfile'];
        $editUsername = $_POST['username'];
        $editPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $editGender = $_POST['gender'];
        $editFullname = $_POST['fullname'];
        // $editProfile = $_POST['profile'];

        $sql_editProfile = "UPDATE user SET username = '$editUsername', password = '$editPassword', gender = '$editGender', fullname = '$editFullname' WHERE username = '$old_id'";
        mysqli_query($conn, $sql_editProfile);
        $update = true;
    }
?>

<div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <?php
                if ($update == true) {
                alertUpdate("Data berhasil diperbarui");
                }
            ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-dark mt-4">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-address-card mr-2"></i>Tampilan Profil</h3>
                            <?php if ($_SESSION['role'] == "User") { ?>
                                <a class="nav-link btn btn-sm d-flex align-items-end flex-column" data-toggle="modal" data-target="#editProfile">
                                <i class="fas fa-cog"></i></a>
                            <?php } ?>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row row-cols-1 row-cols-md-12 md-3">
                                <div class="col">
                                    <div class="card">
                                        <div class="row g-0">
                                            <div class="col-4">
                                                <img src="<?php echo $_SESSION['profile']; ?>" class="img-fluid rounded-start img-profile" alt="gambarpengguna" style="height:240px;max-height:auto;width:240px;max-width:auto;">
                                            </div>
                                            <div class="col-8">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <p class="card-text mt-2">
                                                                <strong><i class="fas fa-file-signature mr-2"></i>Nama Lengkap :</strong><br>
                                                                <p class="text-capitalize">
                                                                    <?php echo $_SESSION['fullname']; ?>
                                                                </p>
                                                            </p>
                                                        </div>
                                                        <div class="col-6">
                                                            <p class="card-text mt-2">
                                                                <strong><i class="fas fa-user mr-2"></i>Username :</strong><br>
                                                                <p class="text-capitalize">
                                                                    <?php echo $_SESSION['username']; ?>
                                                                </p>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3 pt-2">
                                                        <div class="col-6">
                                                            <p class="card-text mt-2">
                                                                <strong><i class="fas fa-female mr-1"></i><i class="fas fa-male mr-2"></i>Jenis Kelamin :</strong><br>
                                                                <p class="text-capitalize">
                                                                    <?php echo $_SESSION['gender']; ?>
                                                                </p>
                                                            </p>
                                                        </div>
                                                        <div class="col-6">
                                                            <p class="card-text mt-2">
                                                                <strong><i class="fas fa-eye mr-2"></i>Hak Akses :</strong><br>
                                                                <p class="text-capitalize">
                                                                    <?php echo $_SESSION['role']; ?>
                                                                </p>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editProfile" tabindex="-1" aria-labelledby="editProfileLabel" aria-hidden="true">
    <div class="modal-dialog" style="min-width:1000px;min-height:500px;align-items:center;">
        <div class="modal-content">
            <div class="modal-header bg-navy text-light">
                <h5 class="modal-title"><i class="fas fa-user-edit mr-2"></i> Ubah Profil</h5>
                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
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
                            <?php if ($_SESSION['gender'] == "Wanita"){ ?>
                                <option value="Wanita">Wanita</option>
                                <option value="Pria">Pria</option>
                            <?php } else { ?>
                                <option value="Pria">Pria</option>
                                <option value="Wanita">Wanita</option>
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
                <div class="modal-footer bg-navy mt-3">
                    <button type="submit" class="btn btn-primary btn-sm btnacc text-light"><i class="fas fa-check mr-2"></i>Setuju</button>
                    <a type="button" class="btn btn-danger btn-sm btncancel text-light" data-dismiss="modal"><i class="fas fa-times mr-2"></i>Batal</a>
                </div>
            </form>   
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