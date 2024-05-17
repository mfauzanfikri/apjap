<?php

$db = new PDO('mysql:host=localhost;dbname=sijadwal', 'root', '', [
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

function getUserByUsername(string $username) {
    $user = fetch('SELECT * FROM user WHERE username = :username', ['username' => $username]);

    return $user;
}
