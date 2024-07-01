<?php

namespace Letalandroid\controllers;

require_once __DIR__ . '/../model/db.php';

use Letalandroid\model\Database;
use Exception;
use PDO;
use PDOException;

class Conducta
{
    static function getAll()
    {
        try {
            $db = new Database();

            $query = $db->connect()->prepare('select * from conducta;');
            $query->execute();

            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (Exception $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
        }
    }

    static function searchAll($alumno_id, $descripcion, $calificacion, $curso_id, $unidad)
    {
        try {
            $db = new Database();

            $query = $db->connect()->prepare('select * from conducta
            where alumno_id=? and descripcion=? and calificacion=? and curso_id=? and bimestre=?;');
            $query->bindValue(1, $alumno_id, PDO::PARAM_INT);
            $query->bindValue(2, $descripcion, PDO::PARAM_STR);
            $query->bindValue(3, $calificacion, PDO::PARAM_STR);
            $query->bindValue(4, $curso_id, PDO::PARAM_INT);
            $query->bindValue(5, $unidad, PDO::PARAM_INT);
            $query->execute();

            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (Exception $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
        }
    }

    static function create($alumno_id, $descripcion, $calificacion, $curso_id, $unidad)
    {
        try {
            $db = new Database();
            $query = $db->connect()->prepare('insert into conducta
                                                (alumno_id, fecha_conducta, descripcion, calificacion, curso_id, bimestre)
                                                values (?,NOW(),?,?,?,?);');

            $query->bindValue(1, $alumno_id, PDO::PARAM_INT);
            $query->bindValue(2, $descripcion, PDO::PARAM_STR);
            $query->bindValue(3, $calificacion, PDO::PARAM_STR);
            $query->bindValue(4, $curso_id, PDO::PARAM_INT);
            $query->bindValue(5, $unidad, PDO::PARAM_INT);
            $query->execute();

            return array('success' => true, 'message' => '📅 Actividad agregado exitosamente');
        } catch (PDOException $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
        }
    }

    static function edit($descripcion, $calificacion, $conducta_id)
    {
        try {
            $db = new Database();
            $query = $db->connect()->prepare('update conducta set descripcion=?, calificacion=?
                                                where conducta_id=?;');

            $query->bindValue(1, $descripcion, PDO::PARAM_STR);
            $query->bindValue(2, $calificacion, PDO::PARAM_STR);
            $query->bindValue(3, $conducta_id, PDO::PARAM_INT);
            $query->execute();

            return array('success' => true, 'message' => '📅 Actividad agregado exitosamente');
        } catch (PDOException $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
        }
    }
    static function getConductaByAlumnoId($alumno_id, $apoderado_id)
    {
        try {
            $db = new Database();

            // Suponiendo que existe una tabla 'asistencias' y una relación con alumnos y apoderados
            $query = $db->connect()->prepare(
                'SELECT a.descripcion 
                 FROM conducta a 
                 INNER JOIN alumnos al ON a.alumno_id = al.alumno_id 
                 INNER JOIN apoderados ap ON al.apoderado_id = ap.apoderado_id 
                 WHERE a.alumno_id = ? AND ap.apoderado_id = ?
                 ORDER BY a.fecha_conducta DESC 
                 LIMIT 2;'
            );

            $query->bindValue(1, $alumno_id, PDO::PARAM_INT);
            $query->bindValue(2, $apoderado_id, PDO::PARAM_INT);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (Exception $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
        }
    }


    static function getByBimestre($alumno_id, $year)
    {
        try {
            $db = new Database();

            // Prepara la consulta para obtener los datos del bimestre especificado
            $query = $db->connect()->prepare('SELECT * FROM conducta WHERE alumno_id=?;');

            // Asigna los valores de las fechas a la consulta
            $query->bindValue(1, $alumno_id, PDO::PARAM_INT);
            // $query->bindValue(2, '2024-01-01', PDO::PARAM_STR);
            // $query->bindValue(3, $year, PDO::PARAM_STR);
            $query->execute();

            // Obtiene los resultados de la consulta
            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (Exception $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
        }
    }
}
