<?php

namespace Letalandroid\controllers;

require_once __DIR__ . '/../model/db.php';
require_once __DIR__ . '/Docente.php';

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

    static function getForIdDoc($docente_id)
    {
        try {

            $docente_dni = Docente::getMinId($docente_id)[0]['dni'];
            $db = new Database();

            $query = $db->connect()->prepare("select * from detalle_aulas_cursos dca
                                            inner join docentes d
                                            on (dca.aula_id=d.aula_id)
                                            inner join cursos c
                                            on (c.curso_id=dca.curso_id)
                                            where d.dni=?;");

            $query->bindValue(1, $docente_dni, PDO::PARAM_STR);
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
                                                right join cursos c
                                                on (d.curso_id=c.curso_id)
                                                order by curso;");
            $query->execute();

            $results = $query->fetchAll(PDO::FETCH_ASSOC);

            return $results;
        } catch (Exception $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
        }
    }

    static function create($nombre)
    {
        try {
            $db = new Database();
            $query = $db->connect()->prepare('insert into cursos (nombre) values (?);');

            $query->bindValue(1, $nombre, PDO::PARAM_STR);
            $query->execute();

            return array('success' => true, 'message' => '📚️ Curso agregado exitosamente');
        } catch (Exception $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
        }
    }
}
