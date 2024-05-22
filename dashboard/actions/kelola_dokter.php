<?php

session_start();

require_once '../services/db.php';
require_once '../utils/utils.php';

$allowedFields = ['id_pegawai', 'spesialisasi', 'no_sip', 'poli'];

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
                header('Location: /dashboard/kelola_dokter.php');
                die();
            }

            $isSuccess = addDokter($data);

            if ($isSuccess === true) {
                $_SESSION['successMsg'] = 'Dokter berhasil ditambahkan.';
            } else {
                $nip = $_POST['nip'];
                $_SESSION['errorMsg'] = "Dokter dengan NIP $nip sudah ada.";
            }

            break;

        case 'edit':
            $data = [];

            if (!isset($_POST['id_dokter'])) {
                $_SESSION['errorMsg'] = "id_dokter tidak ada.";
                header('Location: /dashboard/kelola_dokter.php');
                die();
            }

            foreach ($allowedFields as $field) {
                if (isset($_POST[$field]) && !empty(trim($_POST[$field]))) {
                    $data[$field] = $_POST[$field];
                }
            }

            if (empty($data)) {
                header('Location: /dashboard/kelola_dokter.php');
                die();
            }

            $isSuccess = editDokter($data, $_POST['id_dokter']);

            if ($isSuccess === true) {
                $_SESSION['successMsg'] = 'Dokter berhasil edit.';
            } else {
                $_SESSION['errorMsg'] = "Dokter dengan pegawai sudah ada.";
            }

            break;

        case 'delete':
            $dokterId = $_POST['id_dokter'];

            $isSuccess = deleteDokter($dokterId);

            if ($isSuccess === true) {
                $_SESSION['successMsg'] = 'Dokter berhasil dihapus.';
            } else {
                $_SESSION['errorMsg'] = 'Dokter tidak ditemukan.';
            }

            break;

        default:
            break;
    }

    header('Location: /dashboard/kelola_dokter.php');
    die();
}
