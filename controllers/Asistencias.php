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

    static function getForUpdate($alumno_id, $fecha, $curso_id)
    {
        try {
            $db = new Database();

            $query = $db->connect()->prepare('select * from asistencias
            where alumno_id=? and fecha_asistencia=? and curso_id=?;');
            $query->bindValue(1, $alumno_id, PDO::PARAM_INT);
            $query->bindValue(2, $fecha, PDO::PARAM_STR);
            $query->bindValue(3, $curso_id, PDO::PARAM_INT);
            $query->execute();

            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (Exception $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
        }
    }

    static function getWithDate($fecha, $curso_id)
    {
        try {
            $db = new Database();

            $query = $db->connect()->prepare("select concat(al.apellidos,' ',al.nombres) as nombres_apellidos,
                                            a.*
                                            from alumnos al
                                            left join asistencias a
                                            on (a.alumno_id=al.alumno_id)
                                            where fecha_asistencia=? and curso_id=?
                                            group by al.alumno_id");

            $query->bindValue(1, $fecha, PDO::PARAM_STR);
            $query->bindValue(2, $curso_id, PDO::PARAM_STR);
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

    static function update($alumno_id, $fecha_asistencia, $estado, $descripcion, $curso_id)
    {
        try {
            $db = new Database();
            $query = $db->connect()->prepare('update asistencias
                                                set estado=?, descripcion=?
                                                where alumno_id=? and fecha_asistencia=? and curso_id=?;');

            $query->bindValue(1, $estado, PDO::PARAM_STR);
            $query->bindValue(2, $descripcion, PDO::PARAM_STR);
            $query->bindValue(3, $alumno_id, PDO::PARAM_INT);
            $query->bindValue(4, $fecha_asistencia, PDO::PARAM_STR);
            $query->bindValue(5, $curso_id, PDO::PARAM_INT);
            $query->execute();

            return array('success' => true, 'message' => '🎅 Asistencia registrada exitosamente');
        } catch (Exception $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
        }
    }
}
