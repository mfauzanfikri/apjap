<?php

session_start();

require_once '../services/db.php';
require_once '../utils/utils.php';

$allowedFields = ['id_dokter', 'tanggal', 'waktu_mulai', 'waktu_selesai', 'shift'];

if (isset($_POST['submit'])) {

    // dd($_POST);

    switch ($_POST['jenis']) {
        case 'tambah':
            // validation
            if (!isset($_POST['tanggal'])) {
                $_SESSION['errorMsg'] = 'Kolom tanggal harus diisi.';
                header('Location: /dashboard/kelola_jadwal_dokter.php');
                die();
            }

            if (!isset($_POST['id_dokter_1']) && !isset($_POST['id_dokter_2']) && !isset($_POST['id_dokter_3'])) {
                $_SESSION['errorMsg'] = 'Jadwal praktek dokter harus diisi minimal satu.';
                header('Location: /dashboard/kelola_jadwal_dokter.php');
                die();
            }

            $data = [];

            if (isset($_POST['id_dokter_1'])) {
                $data['pagi'] = [
                    'id_dokter' => $_POST['id_dokter_1'],
                    'tanggal' => $_POST['tanggal'],
                    'waktu_mulai' => '08:00',
                    'waktu_selesai' => '10:00',
                    'shift' => 'pagi'
                ];
            }

            if (isset($_POST['id_dokter_2'])) {
                $data['siang'] = [
                    'id_dokter' => $_POST['id_dokter_2'],
                    'tanggal' => $_POST['tanggal'],
                    'waktu_mulai' => '14:00',
                    'waktu_selesai' => '16:00',
                    'shift' => 'siang'
                ];
            }

            if (isset($_POST['id_dokter_3'])) {
                $data['malam'] = [
                    'id_dokter' => $_POST['id_dokter_3'],
                    'tanggal' => $_POST['tanggal'],
                    'waktu_mulai' => '19:00',
                    'waktu_selesai' => '21:00',
                    'shift' => 'malam'
                ];
            }

            foreach ($data as $d) {
                addJadwalDokter($d);
            }

            $_SESSION['successMsg'] = 'Jadwal dokter berhasil ditambahkan.';

            break;

        case 'edit':
            $data = [];

            if (!isset($_POST['id_jadwal_dokter'])) {
                $_SESSION['errorMsg'] = "id_jadwal_dokter tidak ada.";
                header('Location: /dashboard/kelola_jadwal_dokter.php');
                die();
            }

            if (isset($_POST['tanggal']) && !empty($_POST['tanggal'])) {
                $data['tanggal'] = $_POST['tanggal'];
            }

            if (isset($_POST['id_dokter']) && $_POST['id_dokter'] !== '0') {
                $data['id_dokter'] = $_POST['id_dokter'];
            }

            if (isset($_POST['waktu']) && $_POST['waktu'] !== '0') {
                switch ($_POST['waktu']) {
                    case 'pagi':
                        $data['waktu_mulai'] = '08:00';
                        $data['waktu_selesai'] = '10:00';
                        $data['shift'] = 'pagi';

                        break;
                    case 'siang':
                        $data['waktu_mulai'] = '14:00';
                        $data['waktu_selesai'] = '16:00';
                        $data['shift'] = 'siang';

                        break;
                    case 'malam':
                        $data['waktu_mulai'] = '19:00';
                        $data['waktu_selesai'] = '21:00';
                        $data['shift'] = 'malam';

                        break;
                }
            }

            if (empty($data)) {
                header('Location: /dashboard/kelola_jadwal_dokter.php');
                die();
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

    header('Location: /dashboard/kelola_jadwal_dokter.php');
    die();
}
