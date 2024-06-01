<?php

if (!isset($_SESSION['id_user']) || $_SESSION['role'] === 'pasien') {
  redirect('login.php');
}

// // cek status cuti pegawai
// $pegawaiWithCutiStatus = getPegawaiWithCutiStatus();
// foreach ($pegawaiWithCutiStatus as $pwcs) {
//   $isCuti = getPegawaiCutiToday($pwcs['id_pegawai']);

//   if ($isCuti === false) {
//     editPegawai(['status_pegawai' => 'aktif'], $pwcs['id_pegawai']);
//   }
// }

// // cek status pegawai yang cuti hari ini
// $pegawaiCuti = getPegawaiCutiToday();
// foreach ($pegawaiCuti as $pc) {
//   if ($pc['status_pegawai'] !== 'cuti') {
//     editPegawai(['status_pegawai' => 'cuti'], $pc['id_pegawai']);
//   }
// }

// // cek jadwal dokter yang belum dinotifikasi
// $unnotifiedJadwalDokter = getUnnotifiedJadwalDokterToday();

// foreach ($unnotifiedJadwalDokter as $ujd) {
//   $target = $ujd['no_telepon'];
//   $waktuMulai = $ujd['waktu_mulai'];
//   $waktuSelesai = $ujd['waktu_selesai'];
//   $tanggal = $ujd['tanggal'];
//   $poli = $ujd['poli'];
//   $nama = $ujd['nama'];
//   $nip = $ujd['nip'];

//   $message = "Anda memiliki jadwal praktek hari ini, dengan detail:\n
//   Nama/NIP: $nama/$nip\n
//   Poli: $poli\n
//   Tanggal: $tanggal\n
//   Waktu: $waktuMulai s.d. $waktuSelesai
//   ";

//   $response = sendMessage($target, $message);

//   if ($response->status) {
//     editJadwalDokter(['notifikasi' => 1], $ujd['id_jadwal_dokter']);
//   }
// }

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard</title>
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
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <!-- <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet"> -->
  <link href="assets/vendor/datatables/datatables.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <script src="assets/vendor/jquery/jquery.min.js"></script>

</head>

<body>

  <?php include './layouts/navbar.php'; ?>
  <?php include './layouts/sidebar.php'; ?>