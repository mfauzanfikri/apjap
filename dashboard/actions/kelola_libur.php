<?php

session_start();

require_once '../services/db.php';
require_once '../utils/utils.php';

$allowedFields = ['id_pegawai', 'tanggal'];

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
                redirect('../kelola_libur.php');
            }

            $isSuccess = addLibur($data);

            if ($isSuccess === true) {
                $_SESSION['successMsg'] = 'Dokter berhasil ditambahkan.';
            } else {
                $nip = $_POST['nip'];
                $_SESSION['errorMsg'] = "Dokter dengan NIP $nip sudah ada.";
            }

            $_SESSION['successMsg'] = 'Jadawal libur pegawai berhasil ditambahkan.';

            break;

        case 'edit':
            if (!isset($_POST['id_libur'])) {
                $_SESSION['errorMsg'] = "id_libur tidak ada.";
                redirect('../kelola_libur.php');
            }

            if (!isset($_POST['tanggal'])) {
                redirect('../kelola_libur.php');
            }

            $data['tanggal'] = $_POST['tanggal'];

            $isSuccess = editLibur($data, $_POST['id_libur']);

            $_SESSION['successMsg'] = 'Jadawal libur pegawai berhasil diedit.';

            break;

        case 'delete':
            $id = $_POST['id_libur'];

            $isSuccess = deleteLibur($id);

            if ($isSuccess === true) {
                $_SESSION['successMsg'] = 'Jadawal libur pegawai berhasil dihapus.';
            } else {
                $_SESSION['errorMsg'] = 'Jadawal libur pegawai tidak ditemukan.';
            }

            break;

        default:
            break;
    }

    redirect('../kelola_libur.php');
}
