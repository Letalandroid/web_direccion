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

            $query = $db->connect()->prepare('select * from docentes;');
            $query->execute();

            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (Exception $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
        }
    }

    static function getAllLast()
    {
        try {
            $db = new Database();

            $query = $db->connect()->prepare('select * from docentes order by 1 desc;');
            $query->execute();

            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (Exception $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
        }
    }

    static function getAllMin()
    {
        try {
            $db = new Database();

            $query = $db->connect()->prepare("select dni, concat(nombres,' ',apellidos) as nombres_apellidos,
                                                genero, fecha_nacimiento
                                                from docentes group by dni;");
            $query->execute();

            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (Exception $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
        }
    }

    static function getMinId($id)
    {
        try {
            $db = new Database();

            $query = $db->connect()->prepare("select dni
                                                -- concat(nombres,' ',apellidos) as nombres_apellidos,
                                                -- genero, fecha_nacimiento
                                                from docentes where docente_id=? limit 1;");

            $query->bindValue(1, $id, PDO::PARAM_INT);
            $query->execute();

            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (Exception $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
        }
    }

    static function create($curso_id, $dni, $nombres, $apellidos, $genero, $fecha_nacimiento)
    {
        try {
            $db = new Database();
            $query = $db->connect()->prepare('insert into docentes
                                                (curso_id, dni, nombres, apellidos,
                                                genero, fecha_nacimiento) values
                                                (?,?,?,?,?,?);');

            $query->bindValue(1, $curso_id, PDO::PARAM_INT);
            $query->bindValue(2, $dni, PDO::PARAM_STR);
            $query->bindValue(3, $nombres, PDO::PARAM_STR);
            $query->bindValue(4, $apellidos, PDO::PARAM_STR);
            $query->bindValue(5, $genero, PDO::PARAM_STR);
            $query->bindValue(6, $fecha_nacimiento, PDO::PARAM_STR);
            $query->execute();

            return array('success' => true, 'message' => '🧑‍🏫 Docente agregado exitosamente');

        } catch (Exception $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
        }
    }
}
