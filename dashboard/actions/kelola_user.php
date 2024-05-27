<?php

session_start();

require_once '../services/db.php';
require_once '../utils/utils.php';

if (isset($_POST['submit'])) {
    switch ($_POST['jenis']) {
        case 'tambah':
            $userData = [
                'email' => $_POST['email'],
                'username' => $_POST['username'],
                'password' => $_POST['password'],
            ];

            $isSuccess = addUser($userData);

            if ($isSuccess === true) {
                $_SESSION['successMsg'] = 'User berhasil ditambahkan.';
            } else {
                $_SESSION['errorMsg'] = 'Username atau email sudah ada.';
            }

            break;

        case 'edit':
            $userData = [];

            if (empty($_POST['email']) && empty($_POST['username']) && empty($_POST['password'])) {
                header('Location: /dashboard/kelola_user.php');
                die();
            }

            if (!empty($_POST['email'])) {
                $userData['email'] = $_POST['email'];
            }

            if (!empty($_POST['username'])) {
                $userData['username'] = $_POST['username'];
            }

            if (!empty($_POST['password'])) {
                $userData['password'] = hash('sha256', $_POST['password']);
            }

            $isSuccess = editUser($userData, $_POST['id_user']);

            if ($isSuccess === true) {
                $_SESSION['successMsg'] = 'User berhasil diedit.';
            } else {
                $_SESSION['errorMsg'] = 'Username atau email sudah dipakai.';
            }

            break;

        case 'delete':
            $userId = $_POST['id_user'];

            $isSuccess = deleteUser($userId);

            if ($isSuccess === true) {
                $_SESSION['successMsg'] = 'User berhasil dihapus.';
            } else {
                $_SESSION['errorMsg'] = 'User tidak ditemukan.';
            }

            break;

        case 'ganti_password':
            $user = getUserById($_POST['id_user']);
            $userPassword = $user['password'];
            $password = hash('sha256', $_POST['password']);
            $newPassword = hash('sha256', $_POST['password_baru']);

            if ($userPassword !== $password) {
                $_SESSION['errorMsg'] = 'Password salah.';
                redirect('/dashboard/profil.php');
            }

            if ($userPassword === $newPassword) {
                $_SESSION['errorMsg'] = 'Password baru tidak boleh sama dengan password sekarang.';
                redirect('/dashboard/profil.php');
            }

            if ($_POST['password_baru'] !== $_POST['password_konfirmasi']) {
                $_SESSION['errorMsg'] = 'Password baru dan konfirmasi password tidak sama.';
                redirect('/dashboard/profil.php');
            }

            $data = [
                'password' => $newPassword
            ];

            editUser($data, $_SESSION['id_user']);

            $_SESSION['successMsg'] = 'Password berhasil diganti.';

            redirect('/dashboard/profil.php');

            break;

        default:
            break;
    }

    header('Location: /dashboard/kelola_user.php');
    die();
}
