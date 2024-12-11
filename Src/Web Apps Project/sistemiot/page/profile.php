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
                            <a class="nav-link btn btn-sm d-flex align-items-end flex-column" data-bs-toggle="modal" data-bs-target="#EditProfile">
                            <i class="fas fa-cog"></i></a>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row row-cols-1 row-cols-md-12 md-3">
                                <div class="col">
                                    <div class="card">
                                        <div class="row g-0">
                                            <div class="col-4">
                                                <img src="dist/img/admin.jpg" class="img-fluid rounded-start img-profile" alt="gambarpengguna" style="height:240px;max-height:auto;width:240px;max-width:auto;">
                                            </div>
                                            <div class="col-8">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <p class="card-text mt-2">
                                                                <strong><i class="fas fa-user-alt mr-2"></i>Nama :</strong><br>
                                                                <p class="text-capitalize">
                                                                    <?php echo $_SESSION['fullname'] ?>
                                                                </p>
                                                            </p>
                                                        </div>
                                                        <div class="col-6">
                                                            <p class="card-text mt-2">
                                                                <strong><i class="fas fa-briefcase mr-2"></i>Username :</strong><br>
                                                                <p class="text-capitalize">
                                                                    <?php echo $_SESSION['username'] ?>
                                                                </p>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3 pt-2">
                                                        <div class="col-6">
                                                            <p class="card-text mt-2">
                                                                <strong><i class="fas fa-restroom mr-2"></i>Jenis Kelamin :</strong><br>
                                                                <p class="text-capitalize">
                                                                    <?php echo $_SESSION['gender'] ?>
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

    <div class="modal fade modalmenu" id="EditProfile" tabindex="-1" aria-labelledby="EditProfileLabel" aria-hidden="true">
        <div class="modal-dialog" style="min-width:1000px;min-height:500px;align-items:center;">
            <div class="modal-content">
                <div class="modal-header bg-secondary text-light">
                    <h5 class="modal-title"><i class="bi bi-person-bounding-box me-1"></i> Ubah Profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-2" action="#" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row col-md-12">
                            <div class="col-md-4 mt-4">
                                <label for="prfname" class="col-form-label"><i class="bi bi-person me-1"></i>{{ __('Nama') }}</label>
                                <input type="text" class="form-control mt-2" name="name" id="prfname" value="{{ Auth::user()->name }}" placeholder="Ubah nama..." required>
                            </div>
                            <div class="col-md-4 mt-4">
                                <label for="prfwork" class="col-form-label"><i class="fa-solid fa-briefcase me-1"></i>{{ __('Pekerjaan') }}</label>
                                <input type="text" class="form-control mt-2" name="pekerjaan" id="prfwork" value="{{ Auth::user()->pekerjaan }}" placeholder="Ubah pekerjaan..." required>
                            </div>
                            <div class="col-md-4 mt-4">
                                <label for="prfaddress" class="col-form-label"><i class="fa-solid fa-house-chimney-user me-1"></i>{{ __('Tempat Tinggal') }}</label>
                                <input type="text" class="form-control mt-2" name="tinggal" id="prfaddress" value="{{ Auth::user()->tinggal }}" placeholder="Ubah tempat tinggal..." required>
                            </div>
                        </div>
                        <div class="row col-md-12">
                            <div class="col-md-4 mt-4">
                                <label for="prfemail" class="col-form-label"><i class="bi bi-envelope me-1"></i>{{ __('Email') }}</label>
                                <input type="email" class="form-control mt-2" name="email" id="prfemail" value="{{ Auth::user()->email }}" placeholder="Ubah email..." required>
                            </div>
                            <div class="col-md-4 mt-4">
                                <label for="prfpassword" class="col-form-label"><i class="bi bi-key me-1"></i>{{ __('Kata Sandi') }}</label>
                                <div class="input-group mb-3">
                                    <button onclick="ShowPassProfile()" class="btn btn-outline-secondary mt-2" type="button">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                    <input type="password" class="form-control mt-2" name="password" id="prfpassword" placeholder="Ubah kata sandi..." required>
                                </div>
                            </div>
                            <div class="col-md-4 mt-4">
                                <label for="prfimg" class="col-form-label"><i class="bi bi-card-image me-1"></i>{{ __('Pilih Foto Pengguna') }}</label>
                                <div class="input-group mb-3 mt-2">
                                    <input type="file" class="form-control" name="image" id="prfimg">
                                </div>
                            </div>
                        </div>
                        <div class="row col-md-12">
                            <div class="col-md-12 mt-2">
                                <label for="prfgender" class="col-form-label"><i class="bi bi-gender-ambiguous me-1"></i>{{ __('Pilih Jenis Kelamin Anda') }}</label>
                                <select id="prfgender" name="jenis_kelamin" class="form-select g-3 mb-3" aria-label=".form-select-lg example">
                                    <option value="L" class="text-small" selected>Laki-Laki (L)</option>
                                    <option value="P" class="text-small">Perempuan (P)</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer bg-secondary mt-2">
                            <a type="button" class="btn btn-danger btn-sm btncancel text-light" data-bs-dismiss="modal">
                            <i class="bi bi-person-x me-1"></i> Batal</a>
                            <button type="submit" class="btn btn-primary btn-sm btnacc text-light">
                            <i class="bi bi-person-check me-1"></i> Setuju</button>
                        </div>
                    </form>                    
                </div>
            </div>
        </div>
    </div>
</div>