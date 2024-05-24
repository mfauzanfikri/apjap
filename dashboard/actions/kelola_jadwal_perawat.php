<?php

session_start();

require_once '../services/db.php';
require_once '../utils/utils.php';

$allowedFields = ['id_perawat', 'tanggal', 'waktu_mulai', 'waktu_selesai', 'shift', 'poli'];

if (isset($_POST['submit'])) {
    switch ($_POST['jenis']) {
        case 'tambah':
            // validation
            $data = [];

            $isValid = true;

            foreach ($allowedFields as $field) {
                if ($field === 'waktu_mulai' || $field === 'waktu_selesai') {
                    continue;
                }

                $isValid = isset($_POST[$field]);

                if (isset($_POST[$field]) && $_POST[$field] === "0") {
                    $isValid = false;
                }

                if (!$isValid) {
                    break;
                }

                $data[$field] = $_POST[$field];
            }

            if (!$isValid) {
                $_SESSION['errorMsg'] = 'Semua kolom harus diisi.';
                header('Location: /dashboard/kelola_jadwal_perawat.php');
                die();
            }

            switch ($data['shift']) {
                case '1':
                    $data['waktu_mulai'] = '07:00';
                    $data['waktu_selesai'] = '14:00';
                    break;
                case '2':
                    $data['waktu_mulai'] = '14:00';
                    $data['waktu_selesai'] = '21:00';
                    break;
                case '3':
                    $data['waktu_mulai'] = '21:00';
                    $data['waktu_selesai'] = '07:00';
                    break;
            }

            $isSuccess = addJadwalPerawat($data);

            if ($isSuccess === true) {
                $_SESSION['successMsg'] = 'Jadwal perawat berhasil ditambahkan.';
            } else {
                $nip = $_POST['nip'];
                $_SESSION['errorMsg'] = "Jadwal perawat dengan NIP $nip sudah ada.";
            }

            $_SESSION['successMsg'] = 'Jadwal perawat berhasil ditambahkan.';

            break;

        case 'edit':
            if (!isset($_POST['id_jadwal_perawat'])) {
                $_SESSION['errorMsg'] = "id_jadwal_perawat tidak ada.";
                header('Location: /dashboard/kelola_jadwal_perawat.php');
                die();
            }

            foreach ($allowedFields as $field) {
                if (isset($_POST[$field]) && !empty(trim($_POST[$field]))) {
                    $data[$field] = $_POST[$field];
                }
            }

            if (empty($data)) {
                header('Location: /dashboard/kelola_jadwal_perawat.php');
                die();
            }

            $data['status'] = 'proses';

            $isSuccess = editJadwalPerawat($data, $_POST['id_jadwal_perawat']);

            $_SESSION['successMsg'] = 'Jadwal perawat berhasil diedit.';

            break;

        case 'delete':
            $jdId = $_POST['id_jadwal_perawat'];

            $isSuccess = deleteJadwalPerawat($jdId);

            if ($isSuccess === true) {
                $_SESSION['successMsg'] = 'Jadwal perawat berhasil dihapus.';
            } else {
                $_SESSION['errorMsg'] = 'Jadwal perawat tidak ditemukan.';
            }

            break;

        default:
            break;
    }

    header('Location: /dashboard/kelola_jadwal_perawat.php');
    die();
}
