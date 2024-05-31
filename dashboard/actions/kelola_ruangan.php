<?php

session_start();

require_once '../services/db.php';
require_once '../utils/utils.php';

if (isset($_POST['submit'])) {
    switch ($_POST['jenis']) {
        case 'tambah':
            $ruanganData = [
                'nama' => $_POST['nama']
            ];

            $isSuccess = addRuangan($ruanganData);

            if ($isSuccess === true) {
                $_SESSION['successMsg'] = 'Ruangan berhasil ditambahkan.';
            } else {
                $_SESSION['errorMsg'] = 'Nama ruangan sudah ada.';
            }

            break;

        case 'edit':
            if (empty($_POST['nama']) && empty($_POST['id_ruangan'])) {
                redirect('../kelola_ruangan.php');
            }

            $ruanganData = ['nama' => $_POST['nama']];

            $isSuccess = editRuangan($ruanganData, $_POST['id_ruangan']);

            if ($isSuccess === true) {
                $_SESSION['successMsg'] = 'Ruangan berhasil diedit.';
            } else {
                $_SESSION['errorMsg'] = 'Nama ruangan sudah dipakai.';
            }

            break;

        case 'delete':
            $ruanganId = $_POST['id_ruangan'];

            $isSuccess = deleteRuangan($ruanganId);

            if ($isSuccess === true) {
                $_SESSION['successMsg'] = 'Ruangan berhasil dihapus.';
            } else {
                $_SESSION['errorMsg'] = 'Ruangan tidak ditemukan.';
            }

            break;

        default:
            break;
    }

    redirect('../kelola_ruangan.php');
}
