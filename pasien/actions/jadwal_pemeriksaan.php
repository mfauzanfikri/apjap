<?php

session_start();

require_once '../../dashboard/services/db.php';
require_once '../../dashboard/utils/utils.php';

$inputFields = ['id_pasien', 'poli', 'tanggal', 'shift'];

foreach ($inputFields as $field) {
    if (!isset($_POST[$field])) {
        $_SESSION['errorMsg'] = 'Semua kolom harus diisi.';
        redirect('../jadwal_pemeriksaan.php');
    }
}

['id_pasien' => $pasienId, 'poli' => $poli, 'tanggal' => $tanggal, 'shift' => $shift] = $_POST;
$waktu = $shift === 'pagi' ? '08:00' : ($shift === 'siang' ? '14:00' : '19:00');

$jadwalDokter = getSpecificJadwalDokter($tanggal, $poli, $shift);

if ($jadwalDokter === false) {
    $_SESSION['warningMsg'] = "Mohon maaf jadwal praktek dokter pada tanggal <b>$tanggal</b> jam <b>$waktu</b> di poli <b>$poli</b> tidak tersedia.";
    redirect('../jadwal_pemeriksaan.php');
}

addJadwalDokter(['id_pasien' => $pasienId, 'id_dokter' => $jadwalDokter['id_dokter'], 'tanggal' => $tanggal, 'waktu' => $waktu, 'poli' => $poli]);

$jadwalPemeriksaanId = (getSpecificJadwalPemeriksaan($pasienId, $tanggal, $waktu, $poli))['id_jadwal_pemeriksaan'];

// TODO: logika antrian
$lastNoAntrian = getLastNomorAntrianByJadwalPemeriksaan($poli, $waktu, $tanggal);

if ($lastNoAntrian === false) {
    addAntrianPasien([
        'id_jadwal_pemeriksaan' => "$jadwalPemeriksaanId",
        'no_antrian' => '001'
    ]);
}

// $_SESSION['successMsg'] = "Jadwal pemeriksaan berhasil dibuat.";
// redirect('../jadwal_pemeriksaan.php');
