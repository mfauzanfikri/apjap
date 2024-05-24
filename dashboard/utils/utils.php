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
