<?php

session_start();

require './services/auth.php';
require './utils/utils.php';

if (isset($_SESSION['username'])) {
    redirect('logout.php');
}

checkCutiStatus();
checkNotifikasiJadwalDokter();

$isError = false;

if (isset($_POST) && isset($_POST['submit'])) {

    $nip = $_POST['nip'];
    $password = $_POST['password'];

    $loggedInUser = getUserByNip($nip);
    if ($loggedInUser === false) {
        global $isError;

        $isError = true;
    } else {
        $user = verifyUserDashboard($loggedInUser['username'], $password);

        if (!$user) {
            global $isError;

            $isError = true;
        } else {
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            $pegawai = getPegawaiByUserId($user['id_user']);
            $_SESSION['id_pegawai'] = $pegawai['id_pegawai'];
            $_SESSION['nip'] = $pegawai['nip'];
            $_SESSION['nama'] = $pegawai['nama'];
            $_SESSION['alamat'] = $pegawai['alamat'];
            $_SESSION['no_telepon'] = $pegawai['no_telepon'];
            $_SESSION['status_pegawai'] = $pegawai['status_pegawai'];

            $dokter = getDokterByPegawaiId($pegawai['id_pegawai']);
            $_SESSION['isDokter'] = $dokter !== false ? true : false;
            if ($dokter !== false) {
                $_SESSION['id_dokter'] = $dokter['id_dokter'];
                $_SESSION['spesialisasi'] = $dokter['spesialisasi'];
                $_SESSION['poli'] = $dokter['poli'];
                $_SESSION['no_sip'] = $dokter['no_sip'];
                $_SESSION['profesi'] = 'Dokter';
            }

            $perawat = getPerawatByPegawaiId($pegawai['id_pegawai']);
            $_SESSION['isPerawat'] = $perawat !== false ? true : false;
            if ($perawat !== false) {
                $_SESSION['id_perawat'] = $perawat['id_perawat'];
                $_SESSION['no_sip'] = $perawat['no_sip'];
                $_SESSION['profesi'] = 'Perawat';
            }

            redirect('./');
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Login</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <!-- <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet"> -->

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

    <main>
        <div class="container">
            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8 col-md-6 d-flex flex-column align-items-center justify-content-center">
                            <div class="card mb-3 pb-2">
                                <div class="card-body">
                                    <div class="pt-4 pb-2">
                                        <h1 class="card-title text-center pb-0 fs-4">Aplikasi Jadwal dan Penjadwalan Rumah Sakit Umum Daerah Ogan Ilir (APJAP)</h1>
                                        <p class="text-center small">Log in untuk mengakses sistem.</p>
                                    </div>

                                    <?php if ($isError) : ?>
                                        <div class="mt-2">
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                NIP atau password salah.
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <form action="" method="post" class="row g-3 needs-validation">

                                        <div class="col-12">
                                            <label for="nip" class="form-label">NIP</label>
                                            <div class="input-group has-validation">
                                                <input type="text" name="nip" class="form-control" id="nip" required>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" name="password" class="form-control" id="password" required>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit" name="submit">Login</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <!-- <script src="assets/vendor/apexcharts/apexcharts.min.js"></script> -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script> -->

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>