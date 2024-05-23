<?php

session_start();

require_once '../services/db.php';
require_once '../utils/utils.php';

$allowedFields = ['id_user', 'nip', 'nama', 'alamat', 'no_telepon', 'jabatan', 'status_pegawai'];

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
                header('Location: /dashboard/kelola_pegawai.php');
                die();
            }

            $isSuccess = addPegawai($data);

            if ($isSuccess === true) {
                $_SESSION['successMsg'] = 'Pegawai berhasil ditambahkan.';
            } else {
                $nip = $_POST['nip'];
                $_SESSION['errorMsg'] = "Pegawai dengan NIP $nip sudah ada.";
            }

            break;

        case 'edit':
            $data = [];

            if (!isset($_POST['id_pegawai'])) {
                $_SESSION['errorMsg'] = "id_pegawai tidak ada.";
                header('Location: /dashboard/kelola_pegawai.php');
                die();
            }

            foreach ($allowedFields as $field) {
                if (isset($_POST[$field]) && !empty(trim($_POST[$field]))) {
                    $data[$field] = $_POST[$field];
                }
            }

            if (empty($data)) {
                header('Location: /dashboard/kelola_pegawai.php');
                die();
            }

            $isSuccess = editPegawai($data, $_POST['id_pegawai']);

            if ($isSuccess === true) {
                $_SESSION['successMsg'] = 'Pegawai berhasil edit.';
            } else {
                $nip = $_POST['nip'];
                $_SESSION['errorMsg'] = "Pegawai dengan NIP $nip sudah ada.";
            }

            break;

        case 'delete':
            $pegawaiId = $_POST['id_pegawai'];

            $isSuccess = deletePegawai($pegawaiId);

            if ($isSuccess === true) {
                $_SESSION['successMsg'] = 'Pegawai berhasil dihapus.';
            } else {
                $_SESSION['errorMsg'] = 'Pegawai tidak ditemukan.';
            }

            break;

        default:
            break;
    }

    header('Location: /dashboard/kelola_pegawai.php');
    die();
}