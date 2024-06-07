<?php

session_start();

require_once '../services/db.php';
require_once '../utils/utils.php';

$allowedFields = ['id_dokter', 'tanggal', 'waktu'];

if (isset($_POST['submit'])) {

    // dd($_POST);

    switch ($_POST['jenis']) {
        case 'tambah':
            $dataTemp = [];
            $isValid = true;

            foreach ($allowedFields as $field) {
                $isValid = isset($_POST[$field]);

                if (isset($_POST[$field]) && $_POST[$field] === "0") {
                    $isValid = false;
                }

                if (!$isValid) {
                    break;
                }

                $dataTemp[$field] = $_POST[$field];
            }

            if (!$isValid) {
                $_SESSION['errorMsg'] = 'Semua kolom harus diisi.';
                redirect('../kelola_perawat.php');
            }

            $waktu = explode(' - ', $dataTemp['waktu']);

            $shift = 'satu';

            switch ($dataTemp['waktu']) {
                case implode(' - ', ShiftDokter::JADWAL_SATU):
                    $shift = 'satu';
                    break;

                case implode(' - ', ShiftDokter::JADWAL_DUA):
                    $shift = 'dua';
                    break;

                case implode(' - ', ShiftDokter::JADWAL_TIGA):
                    $shift = 'tiga';
                    break;

                case implode(' - ', ShiftDokter::JADWAL_EMPAT):
                    $shift = 'empat';
                    break;
            }

            $data = [
                'id_dokter' => $dataTemp['id_dokter'],
                'tanggal' => $dataTemp['tanggal'],
                'waktu_mulai' => $waktu[0],
                'waktu_selesai' => $waktu[1],
                'shift' => $shift
            ];

            addJadwalDokter($data);

            $_SESSION['successMsg'] = 'Jadwal dokter berhasil ditambahkan.';

            break;

        case 'edit':
            $data = [];

            if (!isset($_POST['id_jadwal_dokter'])) {
                $_SESSION['errorMsg'] = "id_jadwal_dokter tidak ada.";
                redirect('../kelola_jadwal_dokter.php');
            }

            if (isset($_POST['tanggal']) && !empty($_POST['tanggal'])) {
                $data['tanggal'] = $_POST['tanggal'];
            }

            if (isset($_POST['id_dokter']) && $_POST['id_dokter'] !== '0') {
                $data['id_dokter'] = $_POST['id_dokter'];
            }

            if (isset($_POST['waktu']) && $_POST['waktu'] !== '0') {
                switch ($_POST['waktu']) {
                    case 'JADWAL_SATU':
                        $data['waktu_mulai'] = ShiftDokter::JADWAL_SATU['waktu_mulai'];
                        $data['waktu_selesai'] = ShiftDokter::JADWAL_SATU['waktu_selesai'];
                        $data['shift'] = 'satu';

                        break;

                    case 'JADWAL_DUA':
                        $data['waktu_mulai'] = ShiftDokter::JADWAL_DUA['waktu_mulai'];
                        $data['waktu_selesai'] = ShiftDokter::JADWAL_DUA['waktu_selesai'];
                        $data['shift'] = 'dua';

                        break;

                    case 'JADWAL_TIGA':
                        $data['waktu_mulai'] = ShiftDokter::JADWAL_TIGA['waktu_mulai'];
                        $data['waktu_selesai'] = ShiftDokter::JADWAL_TIGA['waktu_selesai'];
                        $data['shift'] = 'tiga';

                        break;

                    case 'JADWAL_EMPAT':
                        $data['waktu_mulai'] = ShiftDokter::JADWAL_EMPAT['waktu_mulai'];
                        $data['waktu_selesai'] = ShiftDokter::JADWAL_EMPAT['waktu_selesai'];
                        $data['shift'] = 'empat';

                        break;
                }
            }

            if (empty($data)) {
                redirect('../kelola_jadwal_dokter.php');
            }

            $isSuccess = editJadwalDokter($data, $_POST['id_jadwal_dokter']);

            if ($isSuccess === true) {
                $_SESSION['successMsg'] = 'Jadwal dokter berhasil diedit.';
            } else {
                $_SESSION['errorMsg'] = "Jadwal dokter dengan pegawai sudah ada.";
            }

            break;

        case 'delete':
            $jdId = $_POST['id_jadwal_dokter'];

            $isSuccess = deleteJadwalDokter($jdId);

            if ($isSuccess === true) {
                $_SESSION['successMsg'] = 'Jadwal dokter berhasil dihapus.';
            } else {
                $_SESSION['errorMsg'] = 'Jadwal dokter tidak ditemukan.';
            }

            break;

        default:
            break;
    }

    redirect('../kelola_jadwal_dokter.php');
}
