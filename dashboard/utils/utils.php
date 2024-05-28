<?php

function dd(mixed $value) {
    echo '<pre>';
    print_r($value);
    echo '</pre>';
    die();
}

function vd(mixed $value, array ...$values) {
    var_dump($value, $values);
    die();
}

function getStatusColor($status) {
    switch ($status) {
        case 'proses':
            return 'warning';
            break;
        case 'disetujui':
            return 'success';
            break;
        case 'ditolak':
            return 'danger';
            break;

        default:
            return 'primary';
            break;
    }
}

function redirect($url) {
    header("Location: $url");
    die();
}

// rules: role, jabatan, profesi
function authorization($rules) {
    if (!isset($_SESSION['username']) || (!isset($rules['role']) && !isset($rules['jabatan']) && !isset($rules['profesi']))) {
        return false;
    }

    if (isset($rules['role'])) {
        $userRole = $_SESSION['role'];


        if (is_array($rules['role'])) {
            $isAuthorized = array_search($userRole, $rules['role']);

            if ($isAuthorized === false) {
                return false;
            }
        } else {
            if ($rules['role'] !== $userRole) {
                return false;
            }
        }
    }

    if (isset($rules['jabatan'])) {
        $userJabatan = $_SESSION['jabatan'];

        if (is_array($rules['jabatan'])) {
            $isAuthorized = array_search($userJabatan, $rules['jabatan']);

            if ($isAuthorized === false) {
                return false;
            }
        } else {
            if ($rules['jabatan'] !== $userJabatan) {
                return false;
            }
        }
    }

    if (isset($rules['profesi'])) {
        $userIsDokter = $_SESSION['isDokter'];
        $userIsPerawat = $_SESSION['isPerawat'];
        $userProfesi = $userIsDokter ? Profesi::DOKTER : ($userIsPerawat ? Profesi::PERAWAT : null);

        if (is_array($rules['profesi'])) {
            $isAuthorized = array_search($userProfesi, $rules['profesi']);

            if ($isAuthorized === false) {
                return false;
            }
        } else {
            if ($userProfesi !== $rules['profesi']) {
                return false;
            }
        }
    }

    return true;
}

class Role {
    const ADMIN = 'admin';
    const USER = 'user';
    const PASIEN = 'pasien';
}

class Jabatan {
    const KEPALA_BIDANG = 'kepala bidang';
    const KEPALA_SEKSI = 'kepala seksi';
    const STAFF = 'staff';
}

class Profesi {
    const DOKTER = 'dokter';
    const PERAWAT = 'perawat';
}
