<?php

namespace Letalandroid\controllers;

require_once __DIR__ . '/../model/db.php';

use Letalandroid\model\Database;
use Exception;
use PDO;

class Apoderado
{

    static function getAll()
    {
        try {
            $db = new Database();

            $query = $db->connect()->prepare('select * from apoderados;');
            $query->execute();

            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (Exception $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
        }
    }

    static function getId($dni)
    {
        try {
            $db = new Database();

            $query = $db->connect()->prepare('select apoderado_id from apoderados where dni=?;');
            $query->bindValue(1, $dni, PDO::PARAM_STR);
            $query->execute();

            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (Exception $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
        }
    }

    static function getAllFormat()
    {
        try {
            $db = new Database();

            $query = $db->connect()->prepare("select apoderado_id, dni,
                                            concat(nombres,' ',apellidos) as nombres_apellidos,
                                            genero, nacionalidad, fecha_nacimiento
                                            from apoderados;");
            $query->execute();

            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (Exception $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
        }
    }

    static function getAllFormatId($id)
    {
        try {
            $db = new Database();

            $query = $db->connect()->prepare("select apoderado_id, dni,
                                            concat(nombres,' ',apellidos) as nombres_apellidos,
                                            genero, nacionalidad, fecha_nacimiento
                                            from apoderados
                                            where apoderado_id=?;");

            $query->bindValue(1, $id, PDO::PARAM_INT);
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

            $query = $db->connect()->prepare('select * from apoderados order by 1 desc;');
            $query->execute();

            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (Exception $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
        }
    }

    static function getAllReverse()
    {
        try {
            $db = new Database();

            $query = $db->connect()->prepare("select dni, concat(nombres,' ',apellidos) as nombres_apellidos,
                                                nacionalidad, genero, fecha_nacimiento
                                                from apoderados
                                                group by dni
                                                order by 1 desc;");
            $query->execute();

            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (Exception $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
        }
    }

    static function getAllCon()
    {
        try {
            $db = new Database();

            $query = $db->connect()->prepare("select a.alumno_id, ap.dni,ap.apoderado_id,
                                            CONCAT(ap.nombres, ' ', ap.apellidos) AS nombres_apellidos,
                                            ap.fecha_nacimiento, ap.genero, ap.nacionalidad,ap.telefono,ap.correo
                                            from alumnos a
                                            right join apoderados ap
                                            on (a.apoderado_id=ap.apoderado_id)
                                            where alumno_id is not null;");
            $query->execute();

            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (Exception $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
        }
    }

    static function getAllSinAlumn()
    {
        try {
            $db = new Database();

            $query = $db->connect()->prepare("select a.alumno_id, ap.dni,a.apoderado_id,
                                            concat(ap.nombres,' ',ap.apellidos) as    nombres_apellidos,
                                            ap.fecha_nacimiento, ap.genero, ap.nacionalidad, ap.telefono,ap.correo
                                            from alumnos a
                                            right join apoderados ap
                                            on (a.apoderado_id=ap.apoderado_id)
                                            where alumno_id is null;");

            $query->execute();

            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (Exception $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
        }
    }

    static function create($dni, $nombres, $apellidos, $nacionalidad, $genero, $fecha_nacimiento)
    {
        try {
            $db = new Database();
            $query = $db->connect()->prepare('insert into apoderados
                                                (dni, nombres, apellidos, nacionalidad,
                                                genero, fecha_nacimiento) values
                                                (?,?,?,?,?,?);');

            $query->bindValue(1, $dni, PDO::PARAM_STR);
            $query->bindValue(2, $nombres, PDO::PARAM_STR);
            $query->bindValue(3, $apellidos, PDO::PARAM_STR);
            $query->bindValue(4, $nacionalidad, PDO::PARAM_STR);
            $query->bindValue(5, $genero, PDO::PARAM_STR);
            $query->bindValue(6, $fecha_nacimiento, PDO::PARAM_STR);
            $query->execute();

            return array('success' => true, 'message' => '🎅 Apoderado agregado exitosamente');
        } catch (Exception $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
        }
    }

    static function getApoderadosConAlumnos() {
        try {
            $db = new Database();
    
            $query = $db->connect()->prepare("
                SELECT ap.nombres AS apoderado_nombres, 
                       ap.apellidos AS apoderado_apellidos, 
                       ap.dni AS apoderado_dni, 
                       ap.telefono AS apoderado_telefono,
                       ap.correo AS apoderado_correo,
                       ap.nacionalidad AS apoderado_nacionalidad,
                       CONCAT(au.grado, ' ', au.seccion) AS grado_y_seccion,
                       au.nivel AS nivel,
                       a.nombres AS alumno_nombres, 
                       a.apellidos AS alumno_apellidos
                FROM apoderados ap
                LEFT JOIN alumnos a ON ap.apoderado_id = a.apoderado_id
                LEFT JOIN aulas au ON a.aula_id = au.aula_id;
            ");
            $query->execute();
    
            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (Exception $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e->getMessage());
        }
    }
    

}
