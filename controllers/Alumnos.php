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

            $query = $db->connect()->prepare("SELECT al.dni, CONCAT(al.nombres, ' ', al.apellidos) AS nombres_apellidos,al.genero, al.fecha_nacimiento,al.alumno_id,
            CONCAT(a.grado, ' ', a.seccion) AS grado_seccion, a.nivel AS nivel
            FROM alumnos al INNER JOIN aulas a ON al.aula_id = a.aula_id ORDER BY al.dni;");
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

    public static function getById($id)
{
    try {
        $db = new Database();
        $query = $db->connect()->prepare("SELECT a.alumno_id, a.apoderado_id, a.dni, a.nombres, a.apellidos, a.genero, a.fecha_nacimiento, a.aula_id, 
                                            au.grado, au.seccion, au.nivel
                                         FROM alumnos a 
                                         INNER JOIN aulas au ON a.aula_id = au.aula_id
                                         WHERE a.alumno_id = ?");
        $query->bindValue(1, $id, PDO::PARAM_INT);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        http_response_code(500);
        return array('error' => true, 'message' => 'Error en el servidor: ' . $e->getMessage());
    }
}

    public static function update($alumno_id, $apoderado_id, $dni, $nombres, $apellidos, $genero, $fecha_nacimiento, $aula_id) {
        try {
            $db = new Database();
            $query = $db->connect()->prepare("UPDATE alumnos SET apoderado_id = ?, dni = ?, nombres = ?, apellidos = ?, genero = ?, fecha_nacimiento = ?, aula_id = ? WHERE alumno_id = ?");
            $query->bindValue(1, $apoderado_id, PDO::PARAM_INT);
            $query->bindValue(2, $dni, PDO::PARAM_STR);
            $query->bindValue(3, $nombres, PDO::PARAM_STR);
            $query->bindValue(4, $apellidos, PDO::PARAM_STR);
            $query->bindValue(5, $genero, PDO::PARAM_STR);
            $query->bindValue(6, $fecha_nacimiento, PDO::PARAM_STR);
            $query->bindValue(7, $aula_id, PDO::PARAM_INT);
            $query->bindValue(8, $alumno_id, PDO::PARAM_INT);
            $query->execute();

            $queryAula = $db->connect()->prepare("UPDATE aulas SET grado = ?, seccion = ?, nivel = ? WHERE aula_id = ?");
            $queryAula->bindValue(1, $grado, PDO::PARAM_STR);
            $queryAula->bindValue(2, $seccion, PDO::PARAM_STR);
            $queryAula->bindValue(3, $nivel, PDO::PARAM_STR);
            $queryAula->bindValue(4, $aula_id, PDO::PARAM_INT);
            $queryAula->execute();

            return array('success' => true);
        } catch (Exception $e) {
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e->getMessage());
        }
    }

    //eliminar
    public static function eliminar($alumno_id)
{
    try {
        $db = new Database();
        $query = $db->connect()->prepare("DELETE FROM alumnos WHERE alumno_id = ?");
        $query->bindValue(1, $alumno_id, PDO::PARAM_INT); 
        $query->execute();
        if ($query->rowCount() > 0) {
            error_log('Alumno eliminado con ID: ' . $alumno_id); 
            return array('error' => false);
        } else {
            error_log('No se encontró el alumno con ID: ' . $alumno_id); 
            return array('error' => true, 'message' => 'No se encontró el alumno con el ID especificado.');
        }
    } catch (Exception $e) {
        error_log('Error en el servidor: ' . $e->getMessage()); 
        return array('error' => true, 'message' => 'Error en el servidor: ' . $e->getMessage());
    }
}
    
}
