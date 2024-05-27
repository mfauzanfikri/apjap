<?php

session_start();

require_once './services/db.php';
require_once './utils/utils.php';

?>

<?php include './layouts/header.php'; ?>

<script>
    // ubah page title
    $(document).prop('title', 'Profil')
</script>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Profile</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                <li class="breadcrumb-item active">Profile</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">

                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                        <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
                        <h2><?= $_SESSION['nama'] ?></h2>
                        <h3>NIP <?= $_SESSION['nip'] ?>
                            <?php if (isset($_SESSION['profesi'])) : ?>
                                / <span><?= $_SESSION['profesi'] ?></span>
                            <?php endif; ?>
                        </h3>
                    </div>
                </div>

            </div>

            <div class="col-xl-8">

                <div class="card">
                    <div class="card-body pt-3">
                        <?php if (isset($_SESSION['successMsg'])) : ?>
                            <div class="mt-2">
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <?= $_SESSION['successMsg']; ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['errorMsg'])) : ?>
                            <div class="mt-2">
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?= $_SESSION['errorMsg']; ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered">

                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Biodata</button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Ganti Password</button>
                            </li>

                        </ul>
                        <div class="tab-content pt-2">

                            <div class="tab-pane fade show active profile-overview" id="profile-overview">

                                <h5 class="card-title">Detail Profil</h5>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Nama</div>
                                    <div class="col-lg-9 col-md-8"><?= $_SESSION['nama'] ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">NIP</div>
                                    <div class="col-lg-9 col-md-8"><?= $_SESSION['nip'] ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Posisi</div>
                                    <div class="col-lg-9 col-md-8"><?= ucwords($_SESSION['jabatan']) ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Status</div>
                                    <div class="col-lg-9 col-md-8"><?= ucwords($_SESSION['status_pegawai']) ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Alamat</div>
                                    <div class="col-lg-9 col-md-8"><?= $_SESSION['alamat'] ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">No. Telepon</div>
                                    <div class="col-lg-9 col-md-8"><?= $_SESSION['no_telepon'] ?></div>
                                </div>

                                <?php if (isset($_SESSION['profesi'])) : ?>
                                    <h5 class="card-title mt-2">Detail Profesi</h5>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">No. SIP <?= $_SESSION['profesi'] ?></div>
                                        <div class="col-lg-9 col-md-8"><?= $_SESSION['no_sip'] ?></div>
                                    </div>

                                    <?php if ($_SESSION['isDokter']) : ?>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label ">Spesialisasi</div>
                                            <div class="col-lg-9 col-md-8"><?= $_SESSION['spesialisasi'] ?></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label ">Poli</div>
                                            <div class="col-lg-9 col-md-8"><?= $_SESSION['poli'] ?></div>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>

                            </div>

                            <div class="tab-pane fade pt-3" id="profile-change-password">
                                <!-- Change Password Form -->
                                <form action="/dashboard/actions/kelola_user.php" method="post">
                                    <input type="hidden" name="jenis" value="ganti_password">
                                    <input type="hidden" name="id_user" value="<?= $_SESSION['id_user'] ?>">
                                    <div class="row mb-3">
                                        <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Password Sekarang</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="password" type="password" class="form-control" id="currentPassword" required>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Password Baru</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="password_baru" type="password" class="form-control" id="newPassword" required>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Konfirmasi Password Baru</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="password_konfirmasi" type="password" class="form-control" id="renewPassword" required>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" name="submit" class="btn btn-primary">Ganti Password</button>
                                    </div>
                                </form><!-- End Change Password Form -->

                            </div>

                        </div><!-- End Bordered Tabs -->

                    </div>
                </div>

            </div>
        </div>
    </section>

</main><!-- End #main -->

<?php

if (isset($_SESSION['successMsg'])) {
    unset($_SESSION['successMsg']);
}

if (isset($_SESSION['errorMsg'])) {
    unset($_SESSION['errorMsg']);
}

if (isset($_SESSION['warningMsg'])) {
    unset($_SESSION['warningMsg']);
}

?>

<?php

if (isset($_SESSION['successMsg'])) {
    unset($_SESSION['successMsg']);
}

if (isset($_SESSION['errorMsg'])) {
    unset($_SESSION['errorMsg']);
}

if (isset($_SESSION['warningMsg'])) {
    unset($_SESSION['warningMsg']);
}

?>

<?php include './layouts/footer.php'; ?>