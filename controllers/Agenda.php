<?php

namespace Letalandroid\controllers;

require_once __DIR__ . '/../model/db.php';

use Letalandroid\model\Database;
use Exception;
use PDO;
use PDOException;

class Agenda
{

    static function getAll()
    {
        try {
            $db = new Database();

            $query = $db->connect()->prepare('select * from actividad;');
            $query->execute();

            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (Exception $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
        }
    }

    static function getAll_Alumn($curso_id)
    {
        try {
            $db = new Database();

            $query = $db->connect()->prepare('select * from actividad where curso_id=? order by fecha_evento desc;');
            $query->bindValue(1, $curso_id, PDO::PARAM_INT);
            $query->execute();

            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (Exception $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
        }
    }

    static function getAllCurso()
    {
        try {
            $db = new Database();

            $query = $db->connect()->prepare('select c.nombre as curso, a.fecha_evento, a.descripcion
                                            from actividad a
                                            inner join cursos c
                                            on (c.curso_id=a.curso_id);');
            $query->execute();

            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (Exception $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
        }
    }

    static function create($curso_id, $descripcion, $fecha_evento)
    {
        try {
            $db = new Database();
            $query = $db->connect()->prepare('insert into actividad
                                                (curso_id, descripcion, fecha_evento)
                                                values (?,?,?);');

            $query->bindValue(1, $curso_id, PDO::PARAM_INT);
            $query->bindValue(2, $descripcion, PDO::PARAM_STR);
            $query->bindValue(3, $fecha_evento, PDO::PARAM_STR);
            $query->execute();

            return array('success' => true, 'message' => '📅 Actividad agregado exitosamente');

        } catch (PDOException $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
        }
    }
}
