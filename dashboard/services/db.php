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

function getUserByEmail(string $email) {
    $user = fetch('SELECT * FROM user WHERE email = :email', ['email' => $email]);

    return $user;
}

function getUserById(string|int $id) {
    $user = fetch('SELECT * FROM user WHERE id_user = :id_user', ['id_user' => ((string) $id)]);

    return $user;
}

function getUserByPegawaiId(string|int $id) {
    $user = fetch('SELECT a.id_user,a.username,a.email,a.password,a.role FROM user a RIGHT JOIN pegawai b ON a.id_user = b.id_user WHERE b.id_pegawai = :id_pegawai', ['id_pegawai' => ((string) $id)]);

    return $user;
}

function getUserByNip(string|int $nip) {
    $user = fetch('SELECT a.id_user,a.username,a.email,a.password,a.role FROM user a RIGHT JOIN pegawai b ON a.id_user = b.id_user WHERE b.nip = :nip', ['nip' => $nip]);

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
    $pegawai = fetchAll('SELECT id_pegawai,p.id_user,username,nip,nama,alamat,no_telepon,status_pegawai FROM pegawai p LEFT JOIN user u ON p.id_user = u.id_user');

    return $pegawai;
}

function getPegawaiById(string|int $pegawaiId): array|false {
    $pegawai = fetch('SELECT id_pegawai,p.id_user,username,nip,nama,alamat,no_telepon,status_pegawai FROM pegawai p LEFT JOIN user u ON p.id_user = u.id_user WHERE id_pegawai = :id_pegawai', ['id_pegawai' => $pegawaiId]);

    return $pegawai;
}

function getPegawaiByUserId(string|int $userId): array|false {
    $pegawai = fetch('SELECT id_pegawai,p.id_user,username,nip,nama,alamat,no_telepon,status_pegawai FROM pegawai p LEFT JOIN user u ON p.id_user = u.id_user WHERE p.id_user = :id_user', ['id_user' => $userId]);

    return $pegawai;
}

function getPegawaiWithCutiStatus() {
    $pegawai = fetchAll('SELECT id_pegawai,p.id_user,username,nip,nama,alamat,no_telepon,status_pegawai FROM pegawai p LEFT JOIN user u ON p.id_user = u.id_user WHERE p.status_pegawai = :status', ['status' => 'cuti']);

    return $pegawai;
}

function getPegawaiCutiToday() {
    $date = (new DateTime())->format('Y-m-d');
    $query = "SELECT a.id_pegawai,a.id_user,a.nip,a.nama,a.alamat,a.no_telepon,a.status_pegawai,b.id_cuti,b.id_validator,b.tanggal_mulai,b.tanggal_selesai,b.status FROM pegawai a LEFT JOIN cuti b ON a.id_pegawai = b.id_pegawai WHERE b.tanggal_mulai <= :tanggal AND b.tanggal_selesai >= :tanggal AND b.status = :status";

    $pegawai = fetchAll($query, ['tanggal' => $date, 'status' => 'disetujui']);

    return $pegawai;
}

function getPegawaiCutiTodayById($id) {
    $date = (new DateTime())->format('Y-m-d');
    $query = "SELECT a.id_pegawai,a.id_user,a.nip,a.nama,a.alamat,a.no_telepon,a.status_pegawai,b.id_cuti,b.id_validator,b.tanggal_mulai,b.tanggal_selesai,b.status FROM pegawai a LEFT JOIN cuti b ON a.id_pegawai = b.id_pegawai WHERE a.id_pegawai = :id AND b.tanggal_mulai <= :tanggal AND b.tanggal_selesai >= :tanggal AND b.status = :status";

    $pegawai = fetch($query, ['tanggal' => $date, 'id' => $id, 'status' => 'disetujui']);

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

    query('INSERT INTO pegawai (id_user,nip,nama,alamat,no_telepon,status_pegawai) VALUES (:id_user,:nip,:nama,:alamat,:no_telepon,:status_pegawai)', $pegawaiData);

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
    $isExist = getPegawaiById($pegawaiId);

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

// dokter
function getDokter() {
    $dokter = fetchAll('SELECT id_dokter,p.id_pegawai,nama,nip,spesialisasi,poli,no_sip,status_pegawai,status_pegawai FROM dokter p LEFT JOIN pegawai u ON p.id_pegawai = u.id_pegawai');

    return $dokter;
}

function getDokterById(string|int $dokterId): array|false {
    $dokter = fetch('SELECT id_dokter,p.id_pegawai,nama,nip,spesialisasi,poli,no_sip,status_pegawai FROM dokter p LEFT JOIN pegawai u ON p.id_pegawai = u.id_pegawai WHERE id_dokter = :id_dokter', ['id_dokter' => $dokterId]);

    return $dokter;
}

function getDokterByPegawaiId(string|int $pegawaiId): array|false {
    $dokter = fetch('SELECT id_dokter,p.id_pegawai,nama,nip,spesialisasi,poli,no_sip,status_pegawai FROM dokter p LEFT JOIN pegawai u ON p.id_pegawai = u.id_pegawai WHERE p.id_pegawai = :id_pegawai', ['id_pegawai' => $pegawaiId]);

    return $dokter;
}

function addDokter($dokterData) {
    $isDuplicate = fetch('SELECT id_pegawai FROM dokter WHERE id_pegawai = :id_pegawai', ['id_pegawai' => $dokterData['id_pegawai']]);

    if ($isDuplicate !== false) {
        return false;
    }

    $isDuplicate = fetch('SELECT no_sip FROM dokter WHERE no_sip = :no_sip', ['no_sip' => $dokterData['no_sip']]);

    if ($isDuplicate !== false) {
        return false;
    }

    query('INSERT INTO dokter (id_pegawai,spesialisasi,poli,no_sip) VALUES (:id_pegawai,:spesialisasi,:poli,:no_sip)', $dokterData);

    return true;
}

function editDokter($dokterData, $dokterId) {
    if (isset($dokterData['id_pegawai'])) {
        $isDuplicate = fetch('SELECT * FROM dokter WHERE id_pegawai = :id_pegawai', ['id_pegawai' => $dokterData['id_pegawai']]);

        if ($isDuplicate !== false) {
            return false;
        }
    }

    $fieldsTemp = [];

    foreach ($dokterData as $key => $value) {
        $fieldsTemp[] = $key . " = :" . $key;
    }

    $fields = implode(', ', $fieldsTemp);


    query("UPDATE dokter SET $fields WHERE id_dokter = $dokterId", $dokterData);

    return true;
}

function deleteDokter(string|int $dokterId) {
    $isExist = getDokterById($dokterId);

    if (!$isExist) {
        return false;
    }

    query("DELETE FROM dokter WHERE id_dokter = $dokterId");

    return true;
}

function getPegawaiWithNoDokter() {
    $pegawaiWithNoPerawat = 'SELECT p.id_pegawai,p.nip,p.nama FROM pegawai p LEFT JOIN perawat pe ON p.id_pegawai = pe.id_pegawai WHERE pe.id_pegawai IS NULL';
    $pegawai = fetchAll("SELECT p.id_pegawai,p.nip,p.nama FROM ($pegawaiWithNoPerawat) p LEFT JOIN dokter d ON p.id_pegawai = d.id_pegawai WHERE d.id_pegawai IS NULL");

    return $pegawai;
}


// perawat
function getPerawat() {
    $perawat = fetchAll('SELECT id_perawat,p.id_pegawai,nama,nip,no_sip,status_pegawai FROM perawat p LEFT JOIN pegawai u ON p.id_pegawai = u.id_pegawai');

    return $perawat;
}

function getPerawatById(string|int $perawatId): array|false {
    $perawat = fetch('SELECT id_perawat,p.id_pegawai,nama,nip,no_sip,status_pegawai FROM perawat p LEFT JOIN pegawai u ON p.id_pegawai = u.id_pegawai WHERE id_perawat = :id_perawat', ['id_perawat' => $perawatId]);

    return $perawat;
}

function getPerawatByPegawaiId(string|int $pegawaiId): array|false {
    $perawat = fetch('SELECT id_perawat,p.id_pegawai,nama,nip,no_sip,status_pegawai FROM perawat p LEFT JOIN pegawai u ON p.id_pegawai = u.id_pegawai WHERE p.id_pegawai = :id_pegawai', ['id_pegawai' => $pegawaiId]);

    return $perawat;
}

function addPerawat($perawatData) {
    $isDuplicate = fetch('SELECT id_pegawai FROM perawat WHERE id_pegawai = :id_pegawai', ['id_pegawai' => $perawatData['id_pegawai']]);

    if ($isDuplicate !== false) {
        return false;
    }

    query('INSERT INTO perawat (id_pegawai,no_sip) VALUES (:id_pegawai,:no_sip)', $perawatData);

    return true;
}

function editPerawat($perawatData, $perawatId) {
    if (isset($perawatData['id_pegawai'])) {
        $isDuplicate = fetch('SELECT * FROM perawat WHERE id_pegawai = :id_pegawai', ['id_pegawai' => $perawatData['id_pegawai']]);

        if ($isDuplicate !== false) {
            return false;
        }
    }

    $fieldsTemp = [];

    foreach ($perawatData as $key => $value) {
        $fieldsTemp[] = $key . " = :" . $key;
    }

    $fields = implode(', ', $fieldsTemp);


    query("UPDATE perawat SET $fields WHERE id_perawat = $perawatId", $perawatData);

    return true;
}

function deletePerawat(string|int $perawatId) {
    $isExist = getPerawatById($perawatId);

    if (!$isExist) {
        return false;
    }

    query("DELETE FROM perawat WHERE id_perawat = $perawatId");

    return true;
}

function getPegawaiWithNoPerawat() {
    $pegawaiWithNoDokter = 'SELECT p.id_pegawai,p.nip,p.nama FROM pegawai p LEFT JOIN dokter d ON p.id_pegawai = d.id_pegawai WHERE d.id_pegawai IS NULL';
    $pegawai = fetchAll("SELECT p.id_pegawai,p.nip,p.nama FROM ($pegawaiWithNoDokter) p LEFT JOIN perawat pe ON p.id_pegawai = pe.id_pegawai WHERE pe.id_pegawai IS NULL");

    return $pegawai;
}

// jadwal dokter
function getJadwalDokter() {
    $subQuery = 'SELECT jd.id_jadwal_dokter,jd.id_dokter,jd.tanggal,jd.waktu_mulai,jd.waktu_selesai,jd.shift,d.id_pegawai,d.spesialisasi,d.poli,d.no_sip  FROM jadwal_dokter jd LEFT JOIN dokter d ON jd.id_dokter = d.id_dokter';
    $jadwalDokter = fetchAll("SELECT a.id_jadwal_dokter,a.tanggal,a.waktu_mulai,a.waktu_selesai,a.shift,a.spesialisasi,a.poli,a.no_sip,b.nip,b.nama,b.status_pegawai FROM ($subQuery) a LEFT JOIN pegawai b ON a.id_pegawai = b.id_pegawai");

    return $jadwalDokter;
}

function getJadwalDokterById($jdId) {
    $subQuery = 'SELECT jd.id_jadwal_dokter,jd.id_dokter,jd.tanggal,jd.waktu_mulai,jd.waktu_selesai,jd.shift,d.id_pegawai,d.spesialisasi,d.poli,d.no_sip  FROM jadwal_dokter jd LEFT JOIN dokter d ON jd.id_dokter = d.id_dokter';

    $jadwalDokter = fetch("SELECT a.id_jadwal_dokter,a.tanggal,a.waktu_mulai,a.waktu_selesai,a.shift,a.spesialisasi,a.poli,a.no_sip,b.nip,b.nama,b.status_pegawai FROM ($subQuery) a LEFT JOIN pegawai b ON a.id_pegawai = b.id_pegawai WHERE id_jadwal_dokter = $jdId");

    return $jadwalDokter;
}

function getSpecificJadwalDokter($tanggal, $poli, $shift) {
    $subQuery = 'SELECT jd.id_jadwal_dokter,jd.id_dokter,jd.tanggal,jd.waktu_mulai,jd.waktu_selesai,jd.shift,d.id_pegawai,d.spesialisasi,d.poli,d.no_sip  FROM jadwal_dokter jd LEFT JOIN dokter d ON jd.id_dokter = d.id_dokter';

    $query = "SELECT a.id_jadwal_dokter,a.tanggal,a.waktu_mulai,a.waktu_selesai,a.shift,a.spesialisasi,a.poli,a.no_sip,b.nip,b.nama,b.status_pegawai FROM ($subQuery) a LEFT JOIN pegawai b ON a.id_pegawai = b.id_pegawai WHERE a.tanggal = :tanggal AND a.poli = :poli AND a.shift = :shift";

    $jadwalDokter = fetch($query, ['tanggal' => $tanggal, 'poli' => $poli, 'shift' => $shift]);

    return $jadwalDokter;
}

function addJadwalDokter($data) {
    $fieldsTemp = [];
    $placeholdersTemp = [];

    foreach ($data as $key => $value) {
        $fieldsTemp[] = $key;
        $placeholdersTemp[] = ':' . $key;
    }

    $fields = implode(',', $fieldsTemp);
    $placeholders = implode(',', $placeholdersTemp);

    $query = "INSERT INTO jadwal_dokter ($fields) VALUES ($placeholders)";
    query($query, $data);

    return true;
}

function editJadwalDokter($data, $jdId) {
    $fieldsTemp = [];

    foreach ($data as $key => $value) {
        $fieldsTemp[] = $key . " = :" . $key;
    }

    $fields = implode(', ', $fieldsTemp);

    query("UPDATE jadwal_dokter SET $fields WHERE id_jadwal_dokter = $jdId", $data);

    return true;
}

function deleteJadwalDokter(string|int $jdId) {
    $isExist = getJadwalDokterById($jdId);

    if (!$isExist) {
        return false;
    }

    query("DELETE FROM jadwal_dokter WHERE id_jadwal_dokter = $jdId");

    return true;
}

// jadwal perawat
function getJadwalPerawat() {
    $subQuery = 'SELECT jp.id_jadwal_perawat,jp.id_validator,jp.id_perawat,jp.tanggal,jp.waktu_mulai,jp.waktu_selesai,jp.shift,jp.poli,jp.status,p.id_pegawai,p.no_sip FROM jadwal_perawat jp LEFT JOIN perawat p ON jp.id_perawat = p.id_perawat';
    $subQuery2 = "SELECT a.id_jadwal_perawat,a.id_perawat,a.tanggal,a.waktu_mulai,a.waktu_selesai,a.shift,a.poli,a.status,a.id_pegawai,a.no_sip,b.nama nama_validator, b.nip nip_validator FROM ($subQuery) a LEFT JOIN pegawai b ON a.id_validator = b.id_pegawai";
    $jadwalPerawat = fetchAll("SELECT a.id_jadwal_perawat,a.tanggal,a.waktu_mulai,a.waktu_selesai,a.shift,a.poli,a.status,a.no_sip,b.nip,b.nama,b.status_pegawai,a.nama_validator,a.nip_validator FROM ($subQuery2) a LEFT JOIN pegawai b ON a.id_pegawai = b.id_pegawai");

    return $jadwalPerawat;
}

function getJadwalPerawatById($jpId) {
    $subQuery = 'SELECT jp.id_jadwal_perawat,jp.id_validator,jp.id_perawat,jp.tanggal,jp.waktu_mulai,jp.waktu_selesai,jp.shift,jp.poli,jp.status,p.id_pegawai,p.no_sip FROM jadwal_perawat jp LEFT JOIN perawat p ON jp.id_perawat = p.id_perawat WHERE id_jadwal_perawat = $jpId';
    $subQuery2 = "SELECT a.id_jadwal_perawat,a.id_perawat,a.tanggal,a.waktu_mulai,a.waktu_selesai,a.shift,a.poli,a.status,a.id_pegawai,a.no_sip,b.nama nama_validator, b.nip nip_validator FROM ($subQuery) a LEFT JOIN pegawai b ON a.id_validator = b.id_pegawai WHERE id_jadwal_perawat = $jpId";
    $jadwalPerawat = fetch("SELECT a.id_jadwal_perawat,a.tanggal,a.waktu_mulai,a.waktu_selesai,a.shift,a.poli,a.status,a.no_sip,b.nip,b.nama,b.status_pegawai FROM ($subQuery2) a LEFT JOIN pegawai b ON a.id_pegawai = b.id_pegawai WHERE id_jadwal_perawat = $jpId");

    return $jadwalPerawat;
}

function addJadwalPerawat($data) {
    $fieldsTemp = [];
    $placeholdersTemp = [];

    foreach ($data as $key => $value) {
        $fieldsTemp[] = $key;
        $placeholdersTemp[] = ':' . $key;
    }

    $fields = implode(',', $fieldsTemp);
    $placeholders = implode(',', $placeholdersTemp);

    $query = "INSERT INTO jadwal_perawat ($fields) VALUES ($placeholders)";
    query($query, $data);

    return true;
}

function editJadwalPerawat($data, $jpId) {
    $fieldsTemp = [];

    foreach ($data as $key => $value) {
        $fieldsTemp[] = "$key=:$key";
    }

    $fields = implode(', ', $fieldsTemp);

    query("UPDATE jadwal_perawat SET $fields WHERE id_jadwal_perawat = $jpId", $data);

    return true;
}

function deleteJadwalPerawat(string|int $jpId) {
    $isExist = getJadwalPerawatById($jpId);

    if (!$isExist) {
        return false;
    }

    query("DELETE FROM jadwal_perawat WHERE id_jadwal_perawat = $jpId");

    return true;
}

// libur
function getLibur() {
    $libur = fetchAll('SELECT l.id_libur,l.tanggal,p.id_pegawai,p.nama,p.nip,p.status_pegawai FROM libur l LEFT JOIN pegawai p ON l.id_pegawai = p.id_pegawai');

    return $libur;
}

function getLiburById($id) {
    $libur = fetch("SELECT l.id_libur,l.tanggal,p.id_pegawai,p.nama,p.nip,p.status_pegawai FROM libur l LEFT JOIN pegawai p ON l.id_pegawai = p.id_pegawai WHERE l.id_libur = $id");

    return $libur;
}

function getLiburByPegawaiId($id) {
    $libur = fetchAll("SELECT l.id_libur,l.tanggal,p.id_pegawai,p.nama,p.nip,p.status_pegawai FROM libur l LEFT JOIN pegawai p ON l.id_pegawai = p.id_pegawai WHERE p.id_pegawai = :id", ['id' => $id]);

    return $libur;
}

function getLiburThisMonthByPegawaiId($id) {
    $firstDay = (new \DateTime('first day of this month 00:00:00'))->format('Y-m-d');
    $lastDay = (new \DateTime('last day of this month 00:00:00'))->format('Y-m-d');

    $libur = fetchAll("SELECT l.id_libur,l.tanggal,p.id_pegawai,p.nama,p.nip,p.status_pegawai FROM libur l LEFT JOIN pegawai p ON l.id_pegawai = p.id_pegawai WHERE p.id_pegawai = :id AND l.tanggal >= :first_day AND l.tanggal <= :last_day", [
        'id' => $id,
        'first_day' => $firstDay,
        'last_day' => $lastDay
    ]);

    return $libur;
}

function getLiburTodayByPegawaiId($id) {
    $date = (new DateTime())->format('Y-m-d');

    $libur = fetch("SELECT l.id_libur,l.tanggal,p.id_pegawai,p.nama,p.nip,p.status_pegawai FROM libur l LEFT JOIN pegawai p ON l.id_pegawai = p.id_pegawai WHERE p.id_pegawai = :id AND l.tanggal = :tanggal", ['id' => $id, 'tanggal' => $date]);

    return $libur;
}

function addLibur($data) {
    $fieldsTemp = [];
    $placeholdersTemp = [];

    foreach ($data as $key => $value) {
        $fieldsTemp[] = $key;
        $placeholdersTemp[] = ':' . $key;
    }

    $fields = implode(',', $fieldsTemp);
    $placeholders = implode(',', $placeholdersTemp);

    $query = "INSERT INTO libur ($fields) VALUES ($placeholders)";
    query($query, $data);

    return true;
}


function editLibur($data, $id) {
    $fieldsTemp = [];

    foreach ($data as $key => $value) {
        $fieldsTemp[] = $key . " = :" . $key;
    }

    $fields = implode(', ', $fieldsTemp);

    query("UPDATE libur SET $fields WHERE id_libur = $id", $data);

    return true;
}

function deleteLibur(string|int $id) {
    $isExist = getLiburById($id);

    if (!$isExist) {
        return false;
    }

    query("DELETE FROM libur WHERE id_libur = $id");

    return true;
}

// cuti
function getCuti() {
    $subQuery = "SELECT c.id_cuti,c.id_pegawai,c.id_validator,p.nama nama_validator,p.nip nip_validator,c.tanggal_mulai,c.tanggal_selesai,c.status FROM cuti c LEFT JOIN pegawai p ON c.id_validator = p.id_pegawai";

    $cuti = fetchAll("SELECT c.id_cuti,c.id_pegawai,c.id_validator,c.nama_validator,c.nip_validator,c.tanggal_mulai,c.tanggal_selesai,c.status,p.id_pegawai,p.nama,p.nip,p.status_pegawai FROM ($subQuery) c LEFT JOIN pegawai p ON c.id_pegawai = p.id_pegawai");

    return $cuti;
}

function getCutiById($id) {
    $subQuery = "SELECT c.id_cuti,c.id_validator,p.nama nama_validator,p.nip nip_validator,c.tanggal_mulai,c.tanggal_selesai,c.status FROM cuti c LEFT JOIN pegawai p ON c.id_validator = p.id_pegawai";

    $cuti = fetch("SELECT c.id_cuti,c.id_validator,c.nama_validator,c.nip_validator,c.tanggal_mulai,c.tanggal_selesai,c.status,p.id_pegawai,p.nama,p.nip,p.status_pegawai FROM ($subQuery) c LEFT JOIN pegawai p ON c.id_pegawai = p.id_pegawai WHERE c.id_libur = $id");

    return $cuti;
}

function getCutiByPegawaiId($id) {
    $subQuery = "SELECT c.id_cuti,c.id_pegawai,c.id_validator,p.nama nama_validator,p.nip nip_validator,c.tanggal_mulai,c.tanggal_selesai,c.status FROM cuti c LEFT JOIN pegawai p ON c.id_validator = p.id_pegawai";

    $cuti = fetchAll("SELECT c.id_cuti,c.id_pegawai,c.id_validator,c.nama_validator,c.nip_validator,c.tanggal_mulai,c.tanggal_selesai,c.status,p.id_pegawai,p.nama,p.nip,p.status_pegawai FROM ($subQuery) c LEFT JOIN pegawai p ON c.id_pegawai = p.id_pegawai WHERE p.id_pegawai = $id");

    return $cuti;
}

function getCutiThisMonthByPegawaiId($id) {
    $firstDay = (new \DateTime('first day of this month 00:00:00'))->format('Y-m-d');
    $lastDay = (new \DateTime('last day of this month 00:00:00'))->format('Y-m-d');

    $subQuery = "SELECT c.id_cuti,c.id_pegawai,c.id_validator,p.nama nama_validator,p.nip nip_validator,c.tanggal_mulai,c.tanggal_selesai,c.status FROM cuti c LEFT JOIN pegawai p ON c.id_validator = p.id_pegawai AND c.tanggal_mulai >= :first_day AND c.tanggal_mulai <= :last_day";

    $cuti = fetchAll("SELECT c.id_cuti,c.id_pegawai,c.id_validator,c.nama_validator,c.nip_validator,c.tanggal_mulai,c.tanggal_selesai,c.status,p.id_pegawai,p.nama,p.nip,p.status_pegawai FROM ($subQuery) c LEFT JOIN pegawai p ON c.id_pegawai = p.id_pegawai WHERE p.id_pegawai = :id", ['id' => $id, 'first_day' => $firstDay, 'last_day' => $lastDay]);

    return $cuti;
}

function addCuti($data) {
    $fieldsTemp = [];
    $placeholdersTemp = [];

    foreach ($data as $key => $value) {
        $fieldsTemp[] = $key;
        $placeholdersTemp[] = ':' . $key;
    }

    $fields = implode(',', $fieldsTemp);
    $placeholders = implode(',', $placeholdersTemp);

    $query = "INSERT INTO cuti ($fields) VALUES ($placeholders)";
    query($query, $data);

    return true;
}

function editCuti($data, $id) {
    $fieldsTemp = [];

    foreach ($data as $key => $value) {
        $fieldsTemp[] = $key . " = :" . $key;
    }

    $fields = implode(', ', $fieldsTemp);

    query("UPDATE cuti SET $fields WHERE id_cuti = $id", $data);

    return true;
}

function deleteCuti(string|int $id) {
    $isExist = getCutiById($id);

    if (!$isExist) {
        return false;
    }

    query("DELETE FROM cuti WHERE id_cuti = $id");

    return true;
}


// jadwal operasi
function getJadwalOperasi() {
    $subQuery = "SELECT a.id_jadwal_operasi,a.id_pasien,a.id_dokter,a.id_pengaju,a.id_validator,a.id_ruangan,a.tanggal,a.status,b.nama nama_pasien,b.no_telepon no_telepon_pasien FROM jadwal_operasi a LEFT JOIN pasien b ON a.id_pasien = b.id_pasien";

    $subSubQuery2 = 'SELECT id_dokter,p.id_pegawai,nama,nip,spesialisasi,poli,no_sip FROM dokter p LEFT JOIN pegawai u ON p.id_pegawai = u.id_pegawai';

    $subQuery2 = "SELECT a.id_jadwal_operasi,a.id_pasien,a.id_dokter,a.id_pengaju,a.id_validator,a.id_ruangan,a.tanggal,a.status,a.nama_pasien,a.no_telepon_pasien,b.nama nama_dokter,b.nip nip_dokter FROM ($subQuery) a LEFT JOIN ($subSubQuery2) b ON a.id_dokter = b.id_dokter";

    $subQuery3 = "SELECT a.id_jadwal_operasi,a.id_pasien,a.id_dokter,a.id_pengaju,a.id_validator,a.id_ruangan,a.tanggal,a.status,a.nama_pasien,a.no_telepon_pasien,a.nama_dokter,a.nip_dokter,b.nama nama_validator,b.nip nip_validator FROM ($subQuery2) a LEFT JOIN pegawai b ON a.id_validator = b.id_pegawai";

    $subQuery4 = "SELECT a.id_jadwal_operasi,a.id_pasien,a.id_dokter,a.id_pengaju,a.id_validator,a.id_ruangan,a.tanggal,a.status,a.nama_pasien,a.no_telepon_pasien,a.nama_dokter,a.nip_dokter,a.nama_validator,a.nip_validator,b.nama nama_ruangan FROM ($subQuery3) a LEFT JOIN ruangan b ON a.id_ruangan = b.id_ruangan";

    $query = "SELECT a.id_jadwal_operasi,a.id_pasien,a.id_dokter,a.id_pengaju,a.id_validator,a.id_ruangan,a.tanggal,a.status,a.nama_pasien,a.no_telepon_pasien,a.nama_dokter,a.nip_dokter,a.nama_validator,a.nip_validator,a.nama_ruangan,b.nama nama_pengaju,b.nip nip_pengaju FROM ($subQuery4) a LEFT JOIN pegawai b ON a.id_pengaju = b.id_pegawai";

    $jadwalOperasi = fetchAll($query);

    return $jadwalOperasi;
}

function addJadwalOperasi($data) {
    $fieldsTemp = [];
    $placeholdersTemp = [];

    foreach ($data as $key => $value) {
        $fieldsTemp[] = $key;
        $placeholdersTemp[] = ':' . $key;
    }

    $fields = implode(',', $fieldsTemp);
    $placeholders = implode(',', $placeholdersTemp);

    $query = "INSERT INTO jadwal_operasi ($fields) VALUES ($placeholders)";
    query($query, $data);

    return true;
}

function editJadwalOperasi($data, $id) {
    $fieldsTemp = [];

    foreach ($data as $key => $value) {
        $fieldsTemp[] = $key . " = :" . $key;
    }

    $fields = implode(', ', $fieldsTemp);

    query("UPDATE jadwal_operasi SET $fields WHERE id_jadwal_operasi = $id", $data);

    return true;
}


// pasien
function getPasien() {
    $pasien = fetchAll('SELECT a.id_pasien,a.id_user,a.nama,a.alamat,a.no_telepon,b.username,b.email,b.role FROM pasien a LEFT JOIN user b ON a.id_user = b.id_user');

    return $pasien;
}

function registerPasien($data) {
    $userData = [
        'username' => $data['username'],
        'email' => $data['email'],
        'password' => hash('sha256', $data['password']),
        'role' => Role::PASIEN,
    ];

    $fieldsTemp = [];
    $placeholdersTemp = [];

    foreach ($userData as $key => $value) {
        $fieldsTemp[] = $key;
        $placeholdersTemp[] = ':' . $key;
    }

    $fields = implode(',', $fieldsTemp);
    $placeholders = implode(',', $placeholdersTemp);

    $query = "INSERT INTO user ($fields) VALUES ($placeholders)";
    query($query, $userData);

    $createdUser = getUserByUsername($userData['username']);

    $pasienData = [
        'id_user' => $createdUser['id_user'],
        'nama' => $data['nama'],
        'alamat' => $data['alamat'],
        'no_telepon' => $data['nama'],
    ];

    addPasien($pasienData);

    return true;
}

function getPasienByUserId($id) {
    $pasien = fetch('SELECT a.id_pasien,a.id_user,a.nama,a.alamat,a.no_telepon,b.username,b.email,b.role FROM pasien a LEFT JOIN user b ON a.id_user = b.id_user WHERE a.id_user = :id_user', ['id_user' => $id]);

    return $pasien;
}

function addPasien($data) {
    $fieldsTemp = [];
    $placeholdersTemp = [];

    foreach ($data as $key => $value) {
        $fieldsTemp[] = $key;
        $placeholdersTemp[] = ':' . $key;
    }

    $fields = implode(',', $fieldsTemp);
    $placeholders = implode(',', $placeholdersTemp);

    $query = "INSERT INTO pasien ($fields) VALUES ($placeholders)";
    query($query, $data);

    return true;
}

// jadwal pemeriksaan
function getJadwalPemeriksaan() {
    $subQuery = "SELECT a.id_jadwal_pemeriksaan,a.id_pasien,a.id_dokter,a.tanggal,a.waktu,a.poli,b.nama nama_pasien,b.no_telepon no_telepon_pasien FROM jadwal_pemeriksaan a LEFT JOIN pasien b ON a.id_pasien = b.id_pasien";

    $subSubQuery = 'SELECT id_dokter,p.id_pegawai,nama,nip,spesialisasi,poli,no_sip FROM dokter p LEFT JOIN pegawai u ON p.id_pegawai = u.id_pegawai';

    $query = "SELECT a.id_jadwal_pemeriksaan,a.id_pasien,a.id_dokter,a.tanggal,a.waktu,a.poli,a.nama_pasien,a.no_telepon_pasien,b.nama nama_dokter,b.nip nip_dokter FROM ($subQuery) a LEFT JOIN ($subSubQuery) b ON a.id_dokter = b.id_dokter";

    $jadwalPemeriksaan = fetchAll($query);

    return $jadwalPemeriksaan;
}

function getJadwalPemeriksaanCountByDate($date) {
    $query = "SELECT COUNT(id_jadwal_pemeriksaan) count FROM jadwal_pemeriksaan WHERE tanggal = :date";

    $jadwalPemeriksaan = fetch($query, ['date' => $date]);

    return $jadwalPemeriksaan;
}

function getSpecificJadwalPemeriksaan($pasienId, $tanggal, $waktu, $poli) {
    $subQuery = "SELECT a.id_jadwal_pemeriksaan,a.id_pasien,a.id_dokter,a.tanggal,a.waktu,a.poli,b.nama nama_pasien,b.no_telepon no_telepon_pasien FROM jadwal_pemeriksaan a LEFT JOIN pasien b ON a.id_pasien = b.id_pasien";

    $subSubQuery = 'SELECT id_dokter,p.id_pegawai,nama,nip,spesialisasi,poli,no_sip FROM dokter p LEFT JOIN pegawai u ON p.id_pegawai = u.id_pegawai';

    $query = "SELECT a.id_jadwal_pemeriksaan,a.id_pasien,a.id_dokter,a.tanggal,a.waktu,a.poli,a.nama_pasien,a.no_telepon_pasien,b.nama nama_dokter,b.nip nip_dokter FROM ($subQuery) a LEFT JOIN ($subSubQuery) b ON a.id_dokter = b.id_dokter WHERE id_pasien = :id_pasien AND tanggal = :tanggal AND waktu = :waktu AND poli = :poli";

    $jadwalPemeriksaan = fetch($query, ['id_pasien' => $pasienId, 'tanggal' => $tanggal, 'waktu' => $waktu, 'poli' => $poli]);

    return $jadwalPemeriksaan;
}

function addJadwalPemeriksaan($data) {
    $fieldsTemp = [];
    $placeholdersTemp = [];

    foreach ($data as $key => $value) {
        $fieldsTemp[] = $key;
        $placeholdersTemp[] = ':' . $key;
    }

    $fields = implode(',', $fieldsTemp);
    $placeholders = implode(',', $placeholdersTemp);

    $query = "INSERT INTO jadwal_pemeriksaan ($fields) VALUES ($placeholders)";
    query($query, $data);

    return true;
}

// antrian pasien
function getAntrianPasienByJadwalPemeriksaanId($id) {
    // jadwal_pemeriksaan
    $subQuery = "SELECT a.id_antrian_pasien,a.id_jadwal_pasien,a.no_antrian,b.id_pasien,b.id_dokter,b.tanggal,b.waktu,b.poli FROM antrian_pasien a LEFT JOIN jadwal_pemeriksaan b ON a.id_jadwal_pemeriksaan = b.id_jadwal_pemeriksaan WHERE a.id_jadwal_pemeriksaan = :id";

    // pasien
    $subQuery2 = "SELECT a.id_antrian_pasien,a.id_jadwal_pasien,a.no_antrian,a.id_pasien,a.id_dokter,a.tanggal,a.waktu,a.poli,b.id_user,b.nama nama_pasien,b.alamat,b.no_telepon FROM ($subQuery) a LEFT JOIN pasien b ON a.id_pasien = b.id_pasien";

    // dokter pegawai
    $subQuery3 = "SELECT a.id_dokter,a.id_pegawai,a.spesialisasi,a.poli,a.no_sip,b.nip nip_dokter,b.nama nama_dokter FROM dokter a LEFT JOIN pegawai b ON a.id_pegawai = b.id_pegawai";

    // dokter
    $query = "SELECT a.id_antrian_pasien,a.id_jadwal_pasien,a.no_antrian,a.id_pasien,a.id_dokter,a.tanggal,a.waktu,a.poli,a.id_user,a.nama,a.alamat,a.no_telepon,b.id_pegawai,b.spesialisasi,b.poli,b.no_sip,b.nip_dokter,b.nama_dokter FROM ($subQuery2) a LEFT JOIN ($subQuery3) b ON a.id_dokter = b.id_dokter";

    $antrian = fetch($query, ['id' => $id]);

    return $antrian;
}

function getLastNomorAntrianByJadwalPemeriksaan($poli, $waktu, $tanggal) {
    $query = "SELECT a.no_antrian FROM antrian_pasien a LEFT JOIN jadwal_pemeriksaan b ON a.id_jadwal_pemeriksaan = b.id_jadwal_pemeriksaan WHERE b.poli = :poli AND b.waktu = :waktu AND b.tanggal = :tanggal";

    $antrian = fetch($query, ['poli' => $poli, 'waktu' => $waktu, 'tanggal' => $tanggal]);

    return $antrian;
}


function addAntrianPasien($data) {
    $fieldsTemp = [];
    $placeholdersTemp = [];

    foreach ($data as $key => $value) {
        $fieldsTemp[] = $key;
        $placeholdersTemp[] = ':' . $key;
    }

    $fields = implode(',', $fieldsTemp);
    $placeholders = implode(',', $placeholdersTemp);

    $query = "INSERT INTO antrian_pasien ($fields) VALUES ($placeholders)";
    query($query, $data);

    return true;
}
