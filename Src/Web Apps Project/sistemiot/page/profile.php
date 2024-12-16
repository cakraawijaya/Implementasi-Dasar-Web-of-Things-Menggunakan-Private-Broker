<div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-dark mt-4">
                        <div class="card-header">
                            <h3 class="card-title mt-2"><i class="fas fa-address-card mr-2"></i>Tampilan Profil</h3>
                            <?php if ($data['role'] == "User") { ?>
                                <div class="d-flex align-items-end flex-column">
                                    <a href="?page=edit_user_profile" class="nav-link btn btn-sm">
                                    <i class="fas fa-cog mr-1"></i>Ubah</a>
                                </div>
                            <?php } ?>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row md-3">
                                <div class="col">
                                    <div class="card">
                                        <div class="row g-0">
                                            <div class="col-4">
                                                <img src="<?php echo $data['profile']; ?>" class="img-fluid rounded-start" alt="gambarpengguna" style="height:280px;max-height:auto;width:280px;max-width:auto;">
                                            </div>
                                            <div class="col-8">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <p class="card-text mt-2">
                                                                <strong><i class="fas fa-file-signature mr-2"></i>Nama Lengkap :</strong><br>
                                                                <p class="text-capitalize">
                                                                    <?php echo $data['fullname']; ?>
                                                                </p>
                                                            </p>
                                                        </div>
                                                        <div class="col-6">
                                                            <p class="card-text mt-2">
                                                                <strong><i class="fas fa-user mr-2"></i>Username :</strong><br>
                                                                <p class="text">
                                                                    <?php echo $data['username']; ?>
                                                                </p>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3 pt-2">
                                                        <div class="col-6">
                                                            <p class="card-text mt-2">
                                                                <strong><i class="fas fa-female mr-1"></i><i class="fas fa-male mr-2"></i>Jenis Kelamin :</strong><br>
                                                                <p class="text-capitalize">
                                                                    <?php 
                                                                        if ($data['gender'] == "Undefined") {
                                                                            echo "Tidak Dijelaskan"; 
                                                                        } else {
                                                                            echo $data['gender'];
                                                                        }
                                                                    ?>
                                                                </p>
                                                            </p>
                                                        </div>
                                                        <div class="col-6">
                                                            <p class="card-text mt-2">
                                                                <strong><i class="fas fa-eye mr-2"></i>Hak Akses :</strong><br>
                                                                <p class="text-capitalize">
                                                                    <?php echo $data['role']; ?>
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