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

    static function createDocente($docente_id, $username, $password, $rol)
    {
        try {
            $db = new Database();

            $query = $db->connect()->prepare('insert into usuarios (docente_id,username,password,rol)
                                            values (?,?,?,?);');
            $query->bindValue(1, $docente_id, PDO::PARAM_INT);
            $query->bindValue(2, $username, PDO::PARAM_STR);
            $query->bindValue(3, $password, PDO::PARAM_STR);
            $query->bindValue(4, $rol, PDO::PARAM_STR);
            $query->execute();

            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (Exception $e) {
            error_log('Error in Usuarios::getAll(): ' . $e->getMessage());
            return array('error' => true, 'message' => 'Error en el servidor. Por favor, inténtelo de nuevo más tarde.');
        }
    }

    static function createApoderado($apoderado_id, $username, $password, $rol)
    {
        try {
            $db = new Database();

            $query = $db->connect()->prepare('insert into usuarios (username,password,rol,apoderado_id)
                                            values (?,?,?,?);');
            $query->bindValue(1, $username, PDO::PARAM_STR);
            $query->bindValue(2, $password, PDO::PARAM_STR);
            $query->bindValue(3, $rol, PDO::PARAM_STR);
            $query->bindValue(4, $apoderado_id, PDO::PARAM_STR);
            $query->execute();

            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (Exception $e) {
            error_log('Error in Usuarios::getAll(): ' . $e->getMessage());
            return array('error' => true, 'message' => 'Error en el servidor. Por favor, inténtelo de nuevo más tarde.');
        }
    }
}
