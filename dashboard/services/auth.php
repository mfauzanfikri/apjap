<?php

require 'db.php';

function verifyUser(string $email, string $password) {
    $user = getUserByEmail($email);

    if (!$user) {
        return false;
    }

    if ($user['email'] !== $email) {
        return false;
    }

    if ($user['password'] !== hash('sha256', $password)) {
        return false;
    }

    if ($user['role'] !== 'pasien') {
        return false;
    }

    return $user;
}

function verifyUserDashboard(string $username, string $password) {
    $user = getUserByUsername($username);

    if (!$user) {
        return false;
    }

    if ($user['username'] !== $username) {
        return false;
    }

    if ($user['password'] !== hash('sha256', $password)) {
        return false;
    }

    if ($user['role'] === 'pasien') {
        return false;
    }

    return $user;
}
