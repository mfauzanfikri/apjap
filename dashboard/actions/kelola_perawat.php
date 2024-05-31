<?php

session_start();

require_once '../services/db.php';
require_once '../utils/utils.php';

$allowedFields = ['id_pegawai', 'no_sip'];

if (isset($_POST['submit'])) {
    switch ($_POST['jenis']) {
        case 'tambah':
            $data = [];
            $isValid = true;

            foreach ($allowedFields as $field) {
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
                redirect('../kelola_perawat.php');
            }

            $isSuccess = addPerawat($data);

            if ($isSuccess === true) {
                $_SESSION['successMsg'] = 'Perawat berhasil ditambahkan.';
            } else {
                $nip = $_POST['nip'];
                $_SESSION['errorMsg'] = "Perawat dengan NIP $nip sudah ada.";
            }

            break;

        case 'edit':
            $data = [];

            if (!isset($_POST['id_perawat'])) {
                $_SESSION['errorMsg'] = "id_perawat tidak ada.";
                redirect('../kelola_perawat.php');
            }

            foreach ($allowedFields as $field) {
                if (isset($_POST[$field]) && !empty(trim($_POST[$field]))) {
                    $data[$field] = $_POST[$field];
                }
            }

            if (empty($data)) {
                redirect('../kelola_perawat.php');
            }

            $isSuccess = editPerawat($data, $_POST['id_perawat']);

            if ($isSuccess === true) {
                $_SESSION['successMsg'] = 'Perawat berhasil diedit.';
            } else {
                $_SESSION['errorMsg'] = "Perawat dengan pegawai sudah ada.";
            }

            break;

        case 'delete':
            $perawatId = $_POST['id_perawat'];

            $isSuccess = deletePerawat($perawatId);

            if ($isSuccess === true) {
                $_SESSION['successMsg'] = 'Perawat berhasil dihapus.';
            } else {
                $_SESSION['errorMsg'] = 'Perawat tidak ditemukan.';
            }

            break;

        default:
            break;
    }

    redirect('../kelola_perawat.php');
}
