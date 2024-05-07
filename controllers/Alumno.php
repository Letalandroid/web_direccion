<?php

namespace Letalandroid\controllers;

require_once __DIR__ . '/../model/db.php';

use Letalandroid\model\Database;
use Exception;
use PDO;

class Docente
{

    static function getAll()
    {
        try {
            $db = new Database();

            $query = $db->connect()->prepare('select * from alumno;');
            $query->execute();

            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (Exception $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
        }
    }

    static function create($apoderado_id, $dni, $nombres, $apellidos, $genero, $fecha_nacimiento)
    {
        try {
            $db = new Database();
            $query = $db->connect()->prepare('insert into alumno
                                                (apoderado_id, dni, nombres, apellidos,
                                                genero, fecha_nacimiento) values
                                                (?,?,?,?,?,?);');

            $query->bindValue(1, $apoderado_id, PDO::PARAM_STR);
            $query->bindValue(2, $dni, PDO::PARAM_STR);
            $query->bindValue(3, $nombres, PDO::PARAM_STR);
            $query->bindValue(4, $apellidos, PDO::PARAM_STR);
            $query->bindValue(5, $genero, PDO::PARAM_STR);
            $query->bindValue(6, $fecha_nacimiento, PDO::PARAM_STR);
            $query->execute();

            return array('success' => true, 'message' => '🎅 Apoderado agregado exitosamente');

        } catch (Exception $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
        }
    }
}
