<?php

$db = new PDO('mysql:host=localhost;dbname=apkjadwal', 'root', '', [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

/**
 * @throws PDOException
 */
function fetchAll(string $query, array $data = null) {
    global $db;

    try {
        $stmt = $db->prepare($query);

        $stmt->execute($data);

        $result = $stmt->fetchAll();

        return $result;
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int) $e->getCode());
    }
}

/**
 * @throws PDOException
 */
function query(string $query, array $data = null) {
    global $db;

    try {
        $stmt = $db->prepare($query);

        $stmt->execute($data);
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int) $e->getCode());
    }
}

/**
 * @throws PDOException
 */
function fetch(string $query, array $data = null) {
    global $db;

    try {
        $stmt = $db->prepare($query);

        $stmt->execute($data);

        $result = $stmt->fetch();

        return $result;
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int) $e->getCode());
    }
}

// user
function getUserByUsername(string $username) {
    $user = fetch('SELECT * FROM user WHERE username = :username', ['username' => $username]);

    return $user;
}

function getUserById(string|int $id) {
    $user = fetch('SELECT * FROM user WHERE id_user = :id_user', ['id_user' => ((string) $id)]);

    return $user;
}

function getUsers() {
    $users = fetchAll('SELECT * FROM user');

    return $users;
}

function addUser($userData) {
    $data = [
        'email' => $userData['email'],
        'username' => $userData['username'],
        'password' => hash('sha256', $userData['password']),
    ];

    $isDuplicate = fetch('SELECT username FROM user WHERE username = :username', ['username' => $data['username']]);

    if ($isDuplicate !== false) {
        return false;
    }

    $isDuplicate = fetch('SELECT email FROM user WHERE email = :email', ['email' => $data['email']]);

    if ($isDuplicate !== false) {
        return false;
    }

    query('INSERT INTO user (email, username, password) VALUES (:email, :username, :password)', $data);

    return true;
}

function editUser($userData, $userId) {
    if (isset($userData['username'])) {
        $isDuplicate = fetch('SELECT username FROM user WHERE username = :username', ['username' => $userData['username']]);

        if ($isDuplicate !== false) {
            return false;
        }
    }

    if (isset($userData['email'])) {
        $isDuplicate = fetch('SELECT email FROM user WHERE email = :email', ['email' => $userData['email']]);

        if ($isDuplicate !== false) {
            return false;
        }
    }

    $fieldsTemp = [];

    foreach ($userData as $key => $value) {
        $fieldsTemp[] = $key . " = :" . $key;
    }

    $fields = implode(', ', $fieldsTemp);

    query("UPDATE user SET $fields WHERE id_user = $userId", $userData);

    return true;
}

function deleteUser(string|int $userId) {
    $isExist = getUserById($userId);

    if (!$isExist) {
        return false;
    }

    query("DELETE FROM user WHERE id_user = $userId");

    return true;
}

// ruangan
function getRuangan() {
    $ruangan = fetchAll('SELECT * FROM ruangan');

    return $ruangan;
}

function getRuanganById(string|int $ruanganId): array|false {
    $ruangan = fetch('SELECT * FROM ruangan WHERE id_ruangan = :id_ruangan', ['id_ruangan' => $ruanganId]);

    return $ruangan;
}

function addRuangan($ruanganData) {
    $isDuplicate = fetch('SELECT * FROM ruangan WHERE nama = :nama', ['nama' => $ruanganData['nama']]);

    if ($isDuplicate !== false) {
        return false;
    }

    query('INSERT INTO ruangan (nama) VALUES (:nama)', $ruanganData);

    return true;
}

function editRuangan($ruanganData, $ruanganId) {
    if (isset($ruanganData['nama'])) {
        $isDuplicate = fetch('SELECT * FROM ruangan WHERE nama = :nama', ['nama' => $ruanganData['nama']]);

        if ($isDuplicate !== false) {
            return false;
        }
    }


    query("UPDATE ruangan SET nama = :nama WHERE id_ruangan = $ruanganId", $ruanganData);

    return true;
}

function deleteRuangan(string|int $ruanganId) {
    $isExist = getRuanganById($ruanganId);

    if (!$isExist) {
        return false;
    }

    query("DELETE FROM ruangan WHERE id_ruangan = $ruanganId");

    return true;
}

// pegawai
function getPegawai() {
    $pegawai = fetchAll('SELECT id_pegawai,username,nip,nama,alamat,no_telepon,jabatan,status_pegawai FROM pegawai p LEFT JOIN user u ON p.id_user = u.id_user');

    return $pegawai;
}

function getPegawaiById(string|int $pegawaiId): array|false {
    $pegawai = fetch('SELECT id_pegawai,username,nip,nama,alamat,no_telepon,jabatan,status_pegawai FROM pegawai p LEFT JOIN user u ON p.id_user = u.id_user WHERE id_pegawai = :id_pegawai', ['id_pegawai' => $pegawaiId]);

    return $pegawai;
}

function addPegawai($pegawaiData) {
    $isDuplicate = fetch('SELECT nip FROM pegawai WHERE nip = :nip', ['nip' => $pegawaiData['nip']]);

    if ($isDuplicate !== false) {
        return false;
    }

    $isDuplicate = fetch('SELECT id_user FROM pegawai WHERE id_user = :id_user', ['id_user' => $pegawaiData['id_user']]);

    if ($isDuplicate !== false) {
        return false;
    }

    query('INSERT INTO pegawai (id_user,nip,nama,alamat,no_telepon,jabatan,status_pegawai) VALUES (:id_user,:nip,nama,:alamat,:no_telepon,:jabatan,:status_pegawai)', $pegawaiData);

    return true;
}

function editPegawai($pegawaiData, $pegawaiId) {
    if (isset($pegawaiData['nip'])) {
        $isDuplicate = fetch('SELECT * FROM pegawai WHERE nip = :nip', ['nip' => $pegawaiData['nip']]);

        if ($isDuplicate !== false) {
            return false;
        }
    }

    if (isset($pegawaiData['id_user'])) {
        $isDuplicate = fetch('SELECT * FROM pegawai WHERE id_user = :id_user', ['id_user' => $pegawaiData['id_user']]);

        if ($isDuplicate !== false) {
            return false;
        }
    }

    $fieldsTemp = [];

    foreach ($pegawaiData as $key => $value) {
        $fieldsTemp[] = $key . " = :" . $key;
    }

    $fields = implode(', ', $fieldsTemp);


    query("UPDATE pegawai SET $fields WHERE id_pegawai = $pegawaiId", $pegawaiData);

    return true;
}

function deletePegawai(string|int $pegawaiId) {
    $isExist = getRuanganById($pegawaiId);

    if (!$isExist) {
        return false;
    }

    query("DELETE FROM pegawai WHERE id_pegawai = $pegawaiId");

    return true;
}

function getUsersWithNoPegawai() {
    $user = fetchAll('SELECT u.id_user,username FROM user u LEFT JOIN pegawai p ON u.id_user = p.id_user WHERE p.id_pegawai IS NULL AND NOT u.role = "pasien"');

    return $user;
}
