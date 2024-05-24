<?php

session_start();

require_once '../services/db.php';
require_once '../utils/utils.php';

$allowedFields = ['id_pegawai', 'tanggal_mulai', 'tanggal_selesai'];

if (isset($_POST['submit'])) {
    // dd($_POST);
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
                header('Location: /dashboard/kelola_dokter.php');
                die();
            }

            $isSuccess = addCuti($data);

            if ($isSuccess === true) {
                $_SESSION['successMsg'] = 'Dokter berhasil ditambahkan.';
            } else {
                $nip = $_POST['nip'];
                $_SESSION['errorMsg'] = "Dokter dengan NIP $nip sudah ada.";
            }

            $_SESSION['successMsg'] = 'Jadawal cuti pegawai berhasil ditambahkan.';

            break;

        case 'delete':
            $id = $_POST['id_cuti'];

            $isSuccess = deleteCuti($id);

            if ($isSuccess === true) {
                $_SESSION['successMsg'] = 'Jadawal cuti pegawai berhasil dihapus.';
            } else {
                $_SESSION['errorMsg'] = 'Jadawal cuti pegawai tidak ditemukan.';
            }

            break;

        default:
            break;
    }

    header('Location: /dashboard/kelola_cuti.php');
    die();
}
