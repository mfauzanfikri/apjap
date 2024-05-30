<?php

session_start();

require_once '../dashboard/services/auth.php';
require_once '../dashboard/utils/utils.php';

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = verifyUser($email, $password);

    if (!$user) {
        $_SESSION['errorMsg'] = 'Email atau password salah.';
        redirect('/login.php');
    }

    $pasien = getPasienByUserId($user['id_user']);

    $_SESSION['id_user'] = $pasien['id_user'];
    $_SESSION['id_pasien'] = $pasien['id_pasien'];
    $_SESSION['nama'] = $pasien['nama'];
    $_SESSION['alamat'] = $pasien['alamat'];
    $_SESSION['no_telepon'] = $pasien['no_telepon'];
    $_SESSION['username'] = $pasien['username'];
    $_SESSION['email'] = $pasien['email'];
    $_SESSION['role'] = $pasien['role'];

    redirect('../pasien');
}
