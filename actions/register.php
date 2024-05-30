<?php

session_start();

require_once '../dashboard/utils/utils.php';
require_once '../dashboard/services/db.php';

if (isset($_POST['submit'])) {
    // validation
    // email
    $isExist = getUserByEmail($_POST['email']);

    if ($isExist !== false) {
        $_SESSION['errorMsg'] = 'Email sudah dipakai.';
        redirect('/register.php');
    }

    // username
    $isExist = getUserByUsername($_POST['username']);

    if ($isExist !== false) {
        $_SESSION['errorMsg'] = 'Username sudah dipakai.';
        redirect('/register.php');
    }

    // password
    if ($_POST['password'] !== $_POST['konfirmasi_password']) {
        $_SESSION['errorMsg'] = 'Konfirmasi password salah.';
        redirect('/register.php');
    }

    registerPasien($_POST);

    $_SESSION['successMsg'] = 'Akun berhasil dibuat. Silahkan login untuk masuk area pasien.';

    redirect('/login.php');
}
