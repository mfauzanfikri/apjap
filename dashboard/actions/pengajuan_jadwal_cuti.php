<?php

session_start();

require_once '../services/db.php';
require_once '../utils/utils.php';

$editFields = ['id_validator', 'status'];
$allowedFields = ['id_pegawai', 'tanggal_mulai', 'tanggal_selesai'];

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
                redirect('/dashboard/pengajuan_jadwal_cuti.php');
            }

            $isSuccess = addCuti($data);

            if ($isSuccess === true) {
                $_SESSION['successMsg'] = 'Cuti berhasil ditambahkan.';
            }

            $_SESSION['successMsg'] = 'Jadawal cuti pegawai berhasil ditambahkan.';

            break;

        case 'terima':
            $data = [];

            if (!isset($_POST['id_cuti'])) {
                $_SESSION['errorMsg'] = "id_cuti tidak ada.";
                redirect('/dashboard/pengajuan_jadwal_cuti.php');
            }

            foreach ($editFields as $field) {
                if (isset($_POST[$field]) && !empty(trim($_POST[$field]))) {
                    $data[$field] = $_POST[$field];
                }
            }

            if (empty($data)) {
                redirect('/dashboard/pengajuan_jadwal_cuti.php');
            }

            editCuti($data, $_POST['id_cuti']);

            $_SESSION['successMsg'] = 'Cuti berhasil dikonfirmasi.';

            break;

        case 'tolak':
            $data = [];

            if (!isset($_POST['id_cuti'])) {
                $_SESSION['errorMsg'] = "id_cuti tidak ada.";
                redirect('/dashboard/pengajuan_jadwal_cuti.php');
            }

            foreach ($editFields as $field) {
                if (isset($_POST[$field]) && !empty(trim($_POST[$field]))) {
                    $data[$field] = $_POST[$field];
                }
            }

            if (empty($data)) {
                redirect('/dashboard/pengajuan_jadwal_cuti.php');
            }

            editCuti($data, $_POST['id_cuti']);


            $_SESSION['successMsg'] = 'Cuti berhasil dikonfirmasi.';

            break;
    }

    header('Location: /dashboard/pengajuan_jadwal_cuti.php');
    die();
}
