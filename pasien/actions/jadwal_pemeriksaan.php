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

$waktu = '09:00';

switch ($shift) {
    case ShiftDokter::JADWAL_SATU_SYMBOL:
        $waktu = ShiftDokter::JADWAL_SATU['waktu_mulai'];
        break;

    case ShiftDokter::JADWAL_DUA_SYMBOL:
        $waktu = ShiftDokter::JADWAL_DUA['waktu_mulai'];
        break;

    case ShiftDokter::JADWAL_TIGA_SYMBOL:
        $waktu = ShiftDokter::JADWAL_TIGA['waktu_mulai'];
        break;

    case ShiftDokter::JADWAL_EMPAT_SYMBOL:
        $waktu = ShiftDokter::JADWAL_EMPAT['waktu_mulai'];
        break;
}

$jadwalDokter = getSpecificJadwalDokter($tanggal, $poli, $shift);

if ($jadwalDokter === false) {
    $_SESSION['warningMsg'] = "Mohon maaf jadwal praktek dokter pada tanggal <b>$tanggal</b> jam <b>$waktu</b> di poli <b>$poli</b> tidak tersedia.";
    redirect('../jadwal_pemeriksaan.php');
}

addJadwalPemeriksaan(['id_pasien' => $pasienId, 'id_dokter' => $jadwalDokter['id_dokter'], 'tanggal' => $tanggal, 'waktu' => $waktu, 'poli' => $poli]);

$jadwalPemeriksaanId = (getSpecificJadwalPemeriksaan($pasienId, $tanggal, $waktu, $poli))['id_jadwal_pemeriksaan'];

$lastNoAntrian = (getLastNomorAntrianByJadwalPemeriksaan($poli, $waktu, $tanggal));

if ($lastNoAntrian === false) {
    addAntrianPasien([
        'id_jadwal_pemeriksaan' => "$jadwalPemeriksaanId",
        'no_antrian' => '001'
    ]);
} else {
    $trimmedLastNoAntrian = (int) ltrim($lastNoAntrian['no_antrian'], '0');
    $noAntrian = (string) ($trimmedLastNoAntrian + 1);
    $lenght = strlen($noAntrian);

    for ($i = 0; $i < 3 - $lenght; $i++) {
        $noAntrian = '0' . $noAntrian;
    }

    addAntrianPasien([
        'id_jadwal_pemeriksaan' => "$jadwalPemeriksaanId",
        'no_antrian' => $noAntrian
    ]);
}

$_SESSION['successMsg'] = "Jadwal pemeriksaan berhasil dibuat.";
redirect('../jadwal_pemeriksaan.php');
