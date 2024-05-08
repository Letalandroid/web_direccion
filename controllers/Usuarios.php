<?php

namespace Letalandroid\controllers;

require_once __DIR__ . '/../model/db.php';

use Letalandroid\model\Database;
use Exception;
use PDO;

class Usuarios
{

    static function getAll()
    {
        try {
            $db = new Database();

            $query = $db->connect()->prepare('select * from usuarios;');
            $query->execute();

            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (Exception $e) {
            error_log('Error in Usuarios::getAll(): ' . $e->getMessage());
            return array('error' => true, 'message' => 'Error en el servidor. Por favor, inténtelo de nuevo más tarde.');
        }
    }
}
