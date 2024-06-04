<?php

function dd(mixed $value) {
    echo '<pre>';
    print_r($value);
    echo '</pre>';
    die();
}

function vd(mixed $value, array ...$values) {
    var_dump($value, $values);
    die();
}

function getStatusColor($status) {
    switch ($status) {
        case 'proses':
            return 'warning';
            break;
        case 'disetujui':
            return 'success';
            break;
        case 'ditolak':
            return 'danger';
            break;

        default:
            return 'primary';
            break;
    }
}

function redirect($url) {
    header("Location: $url");
    die();
}

// rules: role, jabatan, profesi
function authorization($rules) {
    if (!isset($_SESSION['username']) || (!isset($rules['role']) && !isset($rules['jabatan']) && !isset($rules['profesi']))) {
        return false;
    }

    if (isset($rules['role'])) {
        $userRole = $_SESSION['role'];


        if (is_array($rules['role'])) {
            $isAuthorized = array_search($userRole, $rules['role']);

            if ($isAuthorized === false) {
                return false;
            }
        } else {
            if ($rules['role'] !== $userRole) {
                return false;
            }
        }
    }

    if (isset($rules['profesi'])) {
        $userIsDokter = $_SESSION['isDokter'];
        $userIsPerawat = $_SESSION['isPerawat'];
        $userProfesi = $userIsDokter ? Profesi::DOKTER : ($userIsPerawat ? Profesi::PERAWAT : null);

        if (is_array($rules['profesi'])) {
            $isAuthorized = array_search($userProfesi, $rules['profesi']);

            if ($isAuthorized === false) {
                return false;
            }
        } else {
            if ($userProfesi !== $rules['profesi']) {
                return false;
            }
        }
    }

    return true;
}

class Role {
    const ADMIN = 'admin';
    const PASIEN = 'pasien';
    const PEGAWAI = 'pegawai';
    const ATASAN = 'atasan';
}

class Profesi {
    const DOKTER = 'dokter';
    const PERAWAT = 'perawat';
}

class ShiftDokter {
    const JADWAL_SATU = ['waktu_mulai' => '09:00', 'waktu_selesai' => '13:00'];
    const JADWAL_DUA = ['waktu_mulai' => '09:00', 'waktu_selesai' => '12:00'];
    const JADWAL_TIGA = ['waktu_mulai' => '10:30', 'waktu_selesai' => '13:00'];
    const JADWAL_EMPAT = ['waktu_mulai' => '13:00', 'waktu_selesai' => '16:00'];
}

class ShiftPerawat {
    const PAGI = ['waktu_mulai' => '07:45', 'waktu_selesai' => '16:00'];
    const PAGI_SYMBOL = 'P';
    const MALAM = ['waktu_mulai' => '16:00', 'waktu_selesai' => '07:45'];
    const MALAM_SYMBOL = 'S/M';
    const LIBUR_SYMBOL = 'L';
}

function sendMessage(string $target, string $message) {
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.fonnte.com/send',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array(
            'target' => $target,
            'message' => $message,
            'countryCode' => '62', //optional
        ),
        CURLOPT_HTTPHEADER => array(
            'Authorization: Y4Gz!DN4Cm+D7@zfsHaT' //change TOKEN to your actual token
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);

    return json_decode($response);
}

function checkCutiStatus() {
    // cek status cuti pegawai
    $pegawaiWithCutiStatus = getPegawaiWithCutiStatus();
    foreach ($pegawaiWithCutiStatus as $pwcs) {
        $isCuti = getPegawaiCutiToday($pwcs['id_pegawai']);

        if ($isCuti === false) {
            editPegawai(['status_pegawai' => 'aktif'], $pwcs['id_pegawai']);
        }
    }

    // cek status pegawai yang cuti hari ini
    $pegawaiCuti = getPegawaiCutiToday();
    foreach ($pegawaiCuti as $pc) {
        if ($pc['status_pegawai'] !== 'cuti') {
            editPegawai(['status_pegawai' => 'cuti'], $pc['id_pegawai']);
        }
    }
}

function checkNotifikasiJadwalDokter() {
    // cek jadwal dokter yang belum dinotifikasi
    $unnotifiedJadwalDokter = getUnnotifiedJadwalDokterToday();

    foreach ($unnotifiedJadwalDokter as $ujd) {
        $target = $ujd['no_telepon'];
        $waktuMulai = $ujd['waktu_mulai'];
        $waktuSelesai = $ujd['waktu_selesai'];
        $tanggal = $ujd['tanggal'];
        $poli = $ujd['poli'];
        $nama = $ujd['nama'];
        $nip = $ujd['nip'];

        $message = "Anda memiliki *jadwal praktek dokter* hari ini, dengan detail:\n
  Nama/NIP: $nama/$nip\n
  Poli: $poli\n
  Tanggal: $tanggal\n
  Waktu: $waktuMulai s.d. $waktuSelesai
  ";

        $response = sendMessage($target, $message);

        if ($response->status) {
            editJadwalDokter(['notifikasi' => 1], $ujd['id_jadwal_dokter']);
        }
    }
}

function checkNotifikasiJadwalPerawat() {
    // cek jadwal perawat yang belum dinotifikasi
    $unnotifiedJadwalPerawat = getUnnotifiedJadwalPerawatToday();

    foreach ($unnotifiedJadwalPerawat as $ujp) {
        $target = $ujp['no_telepon'];
        $waktuMulai = $ujp['waktu_mulai'];
        $waktuSelesai = $ujp['waktu_selesai'];
        $shift = $ujp['shift'];
        $tanggal = $ujp['tanggal'];
        $poli = $ujp['poli'];
        $nama = $ujp['nama'];
        $nip = $ujp['nip'];

        $message = "Anda memiliki *jadwal kerja perawat* hari ini, dengan detail:\n
  Nama/NIP: $nama/$nip\n
  Poli: $poli\n
  Tanggal: $tanggal\n
  Shift: $shift\n
  Waktu: $waktuMulai s.d. $waktuSelesai
  ";

        $response = sendMessage($target, $message);

        if ($response->status) {
            editJadwalPerawat(['notifikasi' => 1], $ujp['id_jadwal_perawat']);
        }
    }
}
