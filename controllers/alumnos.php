<?php

namespace Letalandroid\controllers;

require_once __DIR__ . '/../model/db.php';

use Letalandroid\model\Database;
use Exception;
use PDO;

try {
    header('Content-Type: application/json');

    $db = new Database();

    $query = $db->connect()->prepare('select * from users;');
    $query->execute();

    $results = $query->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($results);


} catch (Exception $e) {
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode(['error' => 'Error en el servidor']);
}