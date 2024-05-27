<?php

namespace Letalandroid\controllers;

require_once __DIR__ . '/../model/db.php';

use Letalandroid\model\Database;
use Exception;
use PDO;

class Asistencias
{

    static function getAll()
    {
        try {
            $db = new Database();

            $query = $db->connect()->prepare('select * from asistencias;');
            $query->execute();

            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (Exception $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
        }
    }

    static function getAll_Alumn($alumno_id)
    {
        try {
            $db = new Database();

            $query = $db->connect()->prepare('select * from asistencias where alumno_id=? order by fecha_asistencia desc;');
            $query->bindValue(1, $alumno_id, PDO::PARAM_INT);
            $query->execute();

            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (Exception $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
        }
    }

    static function create($alumno_id, $fecha_asistencia, $estado, $descripcion, $curso_id)
    {
        try {
            $db = new Database();
            $query = $db->connect()->prepare('insert into asistencias
                                                (alumno_id, fecha_asistencia, estado, descripcion, curso_id)
                                                values (?,?,?,?,?);');

            $query->bindValue(1, $alumno_id, PDO::PARAM_INT);
            $query->bindValue(2, $fecha_asistencia, PDO::PARAM_STR);
            $query->bindValue(3, $estado, PDO::PARAM_STR);
            $query->bindValue(4, $descripcion, PDO::PARAM_STR);
            $query->bindValue(5, $curso_id, PDO::PARAM_INT);
            $query->execute();

            return array('success' => true, 'message' => '🎅 Asistencia registrada exitosamente');
        } catch (Exception $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
        }
    }
}
