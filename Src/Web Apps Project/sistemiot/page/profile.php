<?php

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <h1 class="m-0">Profil Saya</h1><hr>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-dark">
                        <div class="card-header">
                            <h3 class="card-title">Tampilan Profil</h3>
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
                                                                <strong><i class="fas fa-user-alt mr-2"></i>Nama :</strong><br>
                                                                <p class="text-capitalize">
                                                                    <?php echo $_SESSION['fullname']; ?>
                                                                </p>
                                                            </p>
                                                        </div>
                                                        <div class="col-6">
                                                            <p class="card-text mt-2">
                                                                <strong><i class="fas fa-briefcase mr-2"></i>Username :</strong><br>
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