<?php

namespace Letalandroid\controllers;

require_once __DIR__ . '/../model/db.php';

use Letalandroid\model\Database;
use Exception;
use PDO;

class Cursos
{

    static function getAll()
    {
        try {
            $db = new Database();

            $query = $db->connect()->prepare("select * from cursos");
            $query->execute();

            $results = $query->fetchAll(PDO::FETCH_ASSOC);

            return $results;
        } catch (Exception $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
        }
    }

    static function getAll_Docente()
    {
        try {
            $db = new Database();

            $query = $db->connect()->prepare("select c.nombre as curso, concat(d.nombres,' ',d.apellidos) as docente
                                                from docentes d
                                                inner join cursos c
                                                on (d.curso_id=c.curso_id);");
            $query->execute();

            $results = $query->fetchAll(PDO::FETCH_ASSOC);

            return $results;
        } catch (Exception $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
        }
    }
}
