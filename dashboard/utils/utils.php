<?php

function dd(mixed $value) {
    echo '<pre>';
    print_r($value);
    echo '</pre>';
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
    if (!isset($_SESSION['username'])) {
        return false;
    }

    if (isset($rules['role'])) {
        $userRole = $_SESSION['role'];

        $isFound = array_search($userRole, $rules['role']);

        if ($isFound === false) {
            return false;
        }
    }

    if (isset($rules['jabatan'])) {
        $userJabatan = $_SESSION['jabatan'];

        $isFound = array_search($userJabatan, $rules['jabatan']);

        if ($isFound === false) {
            return false;
        }
    }

    if (isset($rules['profesi'])) {
        $userIsDokter = $_SESSION['isDokter'];
        $userIsPerawat = $_SESSION['isPerawat'];

        $isFoundPerawat = array_search('perawat', $rules['profesi']);

        if ($isFoundPerawat !== false) {
            if ($userIsPerawat === false) {
                return false;
            }
        }

        $isFoundDokter = array_search('dokter', $rules['profesi']);

        if ($isFoundDokter !== false) {
            if ($userIsDokter === false) {
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
