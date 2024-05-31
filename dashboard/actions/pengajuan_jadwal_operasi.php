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
                redirect('../pengajuan_jadwal_operasi.php');
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
                redirect('../pengajuan_jadwal_operasi.php');
            }

            foreach ($editFields as $field) {
                if (isset($_POST[$field]) && !empty(trim($_POST[$field]))) {
                    $data[$field] = $_POST[$field];
                }
            }

            if (empty($data)) {
                redirect('../pengajuan_jadwal_operasi.php');
            }

            editJadwalOperasi($data, $_POST['id_jadwal_operasi']);

            $_SESSION['successMsg'] = 'Jadwal Operasi berhasil dikonfirmasi.';

            break;

        case 'tolak':
            $data = [];

            if (!isset($_POST['id_jadwal_operasi'])) {
                $_SESSION['errorMsg'] = "id_jadwal_operasi tidak ada.";
                redirect('../pengajuan_jadwal_operasi.php');
            }

            foreach ($editFields as $field) {
                if (isset($_POST[$field]) && !empty(trim($_POST[$field]))) {
                    $data[$field] = $_POST[$field];
                }
            }

            if (empty($data)) {
                redirect('../pengajuan_jadwal_operasi.php');
            }

            editJadwalOperasi($data, $_POST['id_jadwal_operasi']);


            $_SESSION['successMsg'] = 'Jadwal Operasi berhasil dikonfirmasi.';

            break;
    }

    redirect('../pengajuan_jadwal_operasi.php');
}
