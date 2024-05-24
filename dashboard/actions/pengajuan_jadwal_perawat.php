<?php

session_start();

require_once '../services/db.php';
require_once '../utils/utils.php';

$allowedFields = ['id_validator', 'status'];

if (isset($_POST['submit'])) {
    switch ($_POST['jenis']) {
        case 'terima':
            $data = [];

            if (!isset($_POST['id_jadwal_perawat'])) {
                $_SESSION['errorMsg'] = "id_jadwal_perawat tidak ada.";
                header('Location: /dashboard/pengajuan_jadwal_perawat.php');
                die();
            }

            foreach ($allowedFields as $field) {
                if (isset($_POST[$field]) && !empty(trim($_POST[$field]))) {
                    $data[$field] = $_POST[$field];
                }
            }

            if (empty($data)) {
                header('Location: /dashboard/pengajuan_jadwal_perawat.php');
                die();
            }

            editJadwalPerawat($data, $_POST['id_jadwal_perawat']);

            $_SESSION['successMsg'] = 'Jadwal perawat berhasil dikonfirmasi.';

            break;

        case 'tolak':
            $data = [];

            if (!isset($_POST['id_jadwal_perawat'])) {
                $_SESSION['errorMsg'] = "id_jadwal_perawat tidak ada.";
                header('Location: /dashboard/pengajuan_jadwal_perawat.php');
                die();
            }

            foreach ($allowedFields as $field) {
                if (isset($_POST[$field]) && !empty(trim($_POST[$field]))) {
                    $data[$field] = $_POST[$field];
                }
            }

            if (empty($data)) {
                header('Location: /dashboard/pengajuan_jadwal_perawat.php');
                die();
            }

            editJadwalPerawat($data, $_POST['id_jadwal_perawat']);


            $_SESSION['successMsg'] = 'Jadwal perawat berhasil dikonfirmasi.';

            break;
    }

    header('Location: /dashboard/pengajuan_jadwal_perawat.php');
    die();
}
