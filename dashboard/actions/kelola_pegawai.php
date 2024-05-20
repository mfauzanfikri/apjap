<?php

session_start();

require_once '../services/db.php';

if (isset($_POST['submit'])) {
    switch ($_POST['jenis']) {
        case 'tambah':
            var_dump($_POST);
            die();

            break;

        case 'edit':
            var_dump($_POST);
            die();

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
