<?php

session_start();

require_once '../services/db.php';
require_once '../utils/utils.php';

$allowedFields = ['id_perawat', 'tanggal', 'shift', 'poli'];

if (isset($_POST['submit'])) {
    switch ($_POST['jenis']) {
        case 'tambah':
            // validation
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
                redirect('../kelola_jadwal_perawat.php');
            }

            switch ($data['shift']) {
                case ShiftPerawat::PAGI_SYMBOL:
                    $data['waktu_mulai'] = ShiftPerawat::PAGI['waktu_mulai'];
                    $data['waktu_selesai'] = ShiftPerawat::PAGI['waktu_selesai'];
                    break;
                case ShiftPerawat::MALAM_SYMBOL:
                    $data['waktu_mulai'] = ShiftPerawat::MALAM['waktu_mulai'];
                    $data['waktu_selesai'] = ShiftPerawat::MALAM['waktu_selesai'];
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
                redirect('../kelola_jadwal_perawat.php');
            }

            foreach ($allowedFields as $field) {
                if (isset($_POST[$field]) && !empty(trim($_POST[$field]) && $_POST[$field] !== '0')) {
                    $data[$field] = $_POST[$field];
                }
            }

            if (empty($data)) {
                redirect('../kelola_jadwal_perawat.php');
            }

            if (isset($_POST['shift'])) {
                switch ($data['shift']) {
                    case ShiftPerawat::PAGI_SYMBOL:
                        $data['waktu_mulai'] = ShiftPerawat::PAGI['waktu_mulai'];
                        $data['waktu_selesai'] = ShiftPerawat::PAGI['waktu_selesai'];
                        break;
                    case ShiftPerawat::MALAM_SYMBOL:
                        $data['waktu_mulai'] = ShiftPerawat::MALAM['waktu_mulai'];
                        $data['waktu_selesai'] = ShiftPerawat::MALAM['waktu_selesai'];
                        break;
                }
            }

            $data['status'] = 'proses';
            $data['notifikasi'] = 0;

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

    redirect('../kelola_jadwal_perawat.php');
}
