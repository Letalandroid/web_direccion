<?php

namespace Letalandroid\controllers;

require_once __DIR__ . '/../model/db.php';
require_once __DIR__ . '/Apoderado.php';

use Letalandroid\model\Database;
use Exception;
use PDO;
use PDOException;

class Alumnos
{

    static function getAll()
    {
        try {
            $db = new Database();

            $query = $db->connect()->prepare('select * from alumnos;');
            $query->execute();

            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (Exception $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
        }
    }

    static function getAll_Apo($apoderado_id)
    {
        try {
            $db = new Database();

            $query = $db->connect()->prepare('select alumno_id from alumnos where apoderado_id=?;');
            $query->bindValue(1, $apoderado_id, PDO::PARAM_INT);
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

            $query = $db->connect()->prepare('select * from alumnos order by 1 desc;');
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
                                            genero, fecha_nacimiento, alumno_id
                                            from alumnos
                                            group by dni;");
            $query->execute();

            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (Exception $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
        }
    }

    static function create($apoderado_dni, $dni, $nombres, $apellidos, $genero, $fecha_nacimiento)
    {
        try {
            $apoderado_id = Apoderado::getId($apoderado_dni)[0]['apoderado_id'];
            $db = new Database();
            $query = $db->connect()->prepare('insert into alumnos
                                                (apoderado_id, dni, nombres, apellidos,
                                                genero, fecha_nacimiento) values
                                                (?,?,?,?,?,?);');

            $query->bindValue(1, $apoderado_id, PDO::PARAM_INT);
            $query->bindValue(2, $dni, PDO::PARAM_STR);
            $query->bindValue(3, $nombres, PDO::PARAM_STR);
            $query->bindValue(4, $apellidos, PDO::PARAM_STR);
            $query->bindValue(5, $genero, PDO::PARAM_STR);
            $query->bindValue(6, $fecha_nacimiento, PDO::PARAM_STR);
            $query->execute();

            return array('success' => true, 'message' => '🎅 Alumno agregado exitosamente');

        } catch (PDOException $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
        }
    }

    static function getReporteAlumnos() {
        try {
            $db = new Database();
    
            $query = $db->connect()->prepare("
                SELECT a.dni AS alumno_dni,
                       a.nombres AS alumno_nombres,
                       a.apellidos AS alumno_apellidos,
                       a.fecha_nacimiento AS alumno_fecha_nacimiento,
                       CONCAT(au.grado, ' ', au.seccion) AS grado_y_seccion,
                       au.nivel AS nivel,
                       ap.nombres AS apoderado_nombres,
                       ap.apellidos AS apoderado_apellidos,
                       ap.dni AS apoderado_dni,
                       ap.telefono AS apoderado_telefono,
                       ap.correo AS apoderado_correo,
                       ap.nacionalidad AS apoderado_nacionalidad
                FROM alumnos a
                LEFT JOIN apoderados ap ON a.apoderado_id = ap.apoderado_id
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
