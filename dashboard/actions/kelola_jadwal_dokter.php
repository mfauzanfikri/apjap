<?php

session_start();

require_once '../services/db.php';
require_once '../utils/utils.php';

$allowedFields = ['id_dokter', 'tanggal', 'waktu_mulai', 'waktu_selesai', 'shift'];
$addFields = ['poli', 'tanggal', 'id_dokter_1', 'id_dokter_2', 'id_dokter_3'];

if (isset($_POST['submit'])) {

    // dd($_POST);

    switch ($_POST['jenis']) {
        case 'tambah':
            $isValid = true;

            // validation
            foreach ($addFields as $field) {
                $isValid = isset($_POST[$field]);

                if (isset($_POST[$field]) && $_POST[$field] === "0") {
                    $isValid = false;
                }

                if (!$isValid) {
                    break;
                }
            }

            if (!$isValid) {
                $_SESSION['errorMsg'] = 'Semua field harus diisi.';
                header('Location: /dashboard/kelola_jadwal_dokter.php');
                die();
            }

            $data = [
                'pagi' => [
                    'id_dokter' => $_POST['id_dokter_1'],
                    'tanggal' => $_POST['tanggal'],
                    'waktu_mulai' => '08:00',
                    'waktu_selesai' => '10:00',
                    'shift' => 'pagi'
                ],
                'siang' => [
                    'id_dokter' => $_POST['id_dokter_2'],
                    'tanggal' => $_POST['tanggal'],
                    'waktu_mulai' => '14:00',
                    'waktu_selesai' => '16:00',
                    'shift' => 'siang'
                ],
                'malam' => [
                    'id_dokter' => $_POST['id_dokter_3'],
                    'tanggal' => $_POST['tanggal'],
                    'waktu_mulai' => '19:00',
                    'waktu_selesai' => '21:00',
                    'shift' => 'malam'
                ]
            ];

            foreach ($data as $d) {
                addJadwalDokter($d);
            }

            $_SESSION['successMsg'] = 'Jadwal dokter berhasil ditambahkan.';

            break;

        case 'edit':
            dd($_POST);

            $data = [];

            if (!isset($_POST['id_jadwal_dokter'])) {
                $_SESSION['errorMsg'] = "id_jadwal_dokter tidak ada.";
                header('Location: /dashboard/kelola_jadwal_dokter.php');
                die();
            }

            // TODO: editFields

            if (empty($data)) {
                header('Location: /dashboard/kelola_jadwal_dokter.php');
                die();
            }

            $isSuccess = editDokter($data, $_POST['id_jadwal_dokter']);

            if ($isSuccess === true) {
                $_SESSION['successMsg'] = 'Jadwal dokter berhasil edit.';
            } else {
                $_SESSION['errorMsg'] = "Jadwal dokter dengan pegawai sudah ada.";
            }

            break;

        case 'delete':
            dd($_POST);

            $jdId = $_POST['id_jadwal_dokter'];

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
