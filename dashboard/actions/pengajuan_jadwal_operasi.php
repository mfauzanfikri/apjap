<?php

session_start();

require_once '../services/db.php';
require_once '../utils/utils.php';

$allowedFields = ['id_pasien', 'id_dokter', 'id_pengaju', 'id_ruangan', 'tanggal'];

$editFields = ['id_validator', 'status'];

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
                header('Location: /dashboard/pengajuan_jadwal_operasi.php');
                die();
            }

            $isSuccess = addJadwalOperasi($data);

            if ($isSuccess === true) {
                $_SESSION['successMsg'] = 'Jadwal Operasi berhasil diajukan.';
            }

            break;

        case 'terima':
            $data = [];

            if (!isset($_POST['id_jadwal_operasi'])) {
                $_SESSION['errorMsg'] = "id_jadwal_operasi tidak ada.";
                header('Location: /dashboard/pengajuan_jadwal_operasi.php');
                die();
            }

            foreach ($editFields as $field) {
                if (isset($_POST[$field]) && !empty(trim($_POST[$field]))) {
                    $data[$field] = $_POST[$field];
                }
            }

            if (empty($data)) {
                header('Location: /dashboard/pengajuan_jadwal_operasi.php');
                die();
            }

            editJadwalOperasi($data, $_POST['id_jadwal_operasi']);

            $_SESSION['successMsg'] = 'Jadwal Operasi berhasil dikonfirmasi.';

            break;

        case 'tolak':
            $data = [];

            if (!isset($_POST['id_jadwal_operasi'])) {
                $_SESSION['errorMsg'] = "id_jadwal_operasi tidak ada.";
                header('Location: /dashboard/pengajuan_jadwal_operasi.php');
                die();
            }

            foreach ($editFields as $field) {
                if (isset($_POST[$field]) && !empty(trim($_POST[$field]))) {
                    $data[$field] = $_POST[$field];
                }
            }

            if (empty($data)) {
                header('Location: /dashboard/pengajuan_jadwal_operasi.php');
                die();
            }

            editJadwalOperasi($data, $_POST['id_jadwal_operasi']);


            $_SESSION['successMsg'] = 'Jadwal Operasi berhasil dikonfirmasi.';

            break;
    }

    header('Location: /dashboard/pengajuan_jadwal_operasi.php');
    die();
}
