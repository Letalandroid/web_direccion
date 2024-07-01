<?php

namespace Letalandroid\controllers;

require_once __DIR__ . '/../model/db.php';
require_once __DIR__ . '/Docente.php';

use Letalandroid\model\Database;
use Exception;
use PDO;

class Aulas
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

            $query = $db->connect()->prepare("select * from cursos c
                                            inner join docentes d
                                            on (c.curso_id=d.curso_id)
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

    // Función para obtener datos de aulas y docentes
public static function getAllAulasDocentes()
{
    try {
        $db = new Database();
        $query = $db->connect()->prepare("SELECT a.nivel, a.grado, a.seccion, CONCAT(d.nombres, ' ', d.apellidos) AS docente
                                          FROM aulas a
                                          LEFT JOIN docentes d ON a.aula_id = d.aula_id
                                          ORDER BY a.nivel, a.grado, a.seccion;");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        http_response_code(500);
        return array('error' => true, 'message' => 'Error en el servidor: ' . $e->getMessage());
    }
}
    //funcion de reporte general pdf
    public static function getAulasDocentesAlumnos()
{
    try {
        $db = new Database();
        $query = $db->connect()->prepare("SELECT 
                                              a.nivel, a.grado, a.seccion, 
                                              CONCAT(d.nombres, ' ', d.apellidos) AS docente, 
                                              alu.nombres AS alumno_nombres, alu.apellidos AS alumno_apellidos, alu.dni AS alumno_dni, 
                                              apo.nombres AS apoderado_nombres, apo.apellidos AS apoderado_apellidos
                                          FROM aulas a
                                          LEFT JOIN docentes d ON a.aula_id = d.aula_id
                                          LEFT JOIN alumnos alu ON a.aula_id = alu.aula_id
                                          LEFT JOIN apoderados apo ON alu.apoderado_id = apo.apoderado_id
                                          ORDER BY a.nivel, a.grado, a.seccion, alu.apellidos, alu.nombres;");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        http_response_code(500);
        return array('error' => true, 'message' => 'Error en el servidor: ' . $e->getMessage());
    }
}

// para crear nuevas aulas
public static function addAula($grado, $seccion, $nivel)
{
    try {
        $db = new Database();
        
        // Check if the aula already exists
        $query = $db->connect()->prepare("SELECT COUNT(*) FROM aulas WHERE grado = :grado AND seccion = :seccion AND nivel = :nivel");
        $query->bindParam(':grado', $grado, PDO::PARAM_INT);
        $query->bindParam(':seccion', $seccion, PDO::PARAM_STR);
        $query->bindParam(':nivel', $nivel, PDO::PARAM_STR);
        $query->execute();
        
        if ($query->fetchColumn() > 0) {
            return array('error' => true, 'message' => 'El aula ya existe.');
        }
        
        // Insert new aula if it does not exist
        $query = $db->connect()->prepare("INSERT INTO aulas (grado, seccion, nivel) VALUES (:grado, :seccion, :nivel)");
        $query->bindParam(':grado', $grado, PDO::PARAM_INT);
        $query->bindParam(':seccion', $seccion, PDO::PARAM_STR);
        $query->bindParam(':nivel', $nivel, PDO::PARAM_STR);
        $query->execute();
        
        return array('error' => false, 'message' => 'Aula agregada con éxito.');
    } catch (Exception $e) {
        http_response_code(500);
        return array('error' => true, 'message' => 'Error en el servidor: ' . $e->getMessage());
    }
}

// Función para obtener datos completos del docente a cargo del aula
public static function getDocenteAula($grado, $seccion, $nivel)
{
    try {
        $db = new Database();
        $query = $db->connect()->prepare("SELECT d.dni, d.nombres, d.apellidos, d.genero, d.fecha_nacimiento, d.correo, d.telefono
                                          FROM aulas a
                                          LEFT JOIN docentes d ON a.aula_id = d.aula_id
                                          WHERE a.grado = :grado AND a.seccion = :seccion AND a.nivel = :nivel;");
        $query->bindParam(':grado', $grado, PDO::PARAM_INT);
        $query->bindParam(':seccion', $seccion, PDO::PARAM_STR);
        $query->bindParam(':nivel', $nivel, PDO::PARAM_STR);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        http_response_code(500);
        return array('error' => true, 'message' => 'Error en el servidor: ' . $e->getMessage());
    }
}
// Función para Obtener todos los alumnos del aula específica
public static function getAlumnosAula($grado, $seccion, $nivel)
{
    try {
        $db = new Database();
        $query = $db->connect()->prepare("SELECT alu.dni, alu.nombres, alu.apellidos, alu.genero, alu.fecha_nacimiento, apo.nombres AS apoderado_nombres, apo.apellidos AS apoderado_apellidos
                                          FROM aulas a
                                          LEFT JOIN alumnos alu ON a.aula_id = alu.aula_id
                                          LEFT JOIN apoderados apo ON alu.apoderado_id = apo.apoderado_id
                                          WHERE a.grado = :grado AND a.seccion = :seccion AND a.nivel = :nivel
                                          ORDER BY alu.apellidos, alu.nombres;");
        $query->bindParam(':grado', $grado, PDO::PARAM_INT);
        $query->bindParam(':seccion', $seccion, PDO::PARAM_STR);
        $query->bindParam(':nivel', $nivel, PDO::PARAM_STR);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        http_response_code(500);
        return array('error' => true, 'message' => 'Error en el servidor: ' . $e->getMessage());
    }
}
// Función para obtener todos los docentes disponibles que no tienen aulas asignadas
public static function getDocentesDisponibles()
{
    try {
        $db = new Database();

        $query = $db->connect()->prepare("SELECT d.docente_id, d.nombres, d.apellidos 
                                          FROM docentes d
                                          LEFT JOIN aulas a ON d.aula_id = a.aula_id
                                          WHERE a.aula_id IS NULL
                                          ORDER BY d.apellidos, d.nombres");
        $query->execute();

        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    } catch (Exception $e) {
        http_response_code(500);
        return array('error' => true, 'message' => 'Error en el servidor: ' . $e->getMessage());
    }
}

// Método para actualizar el docente de un aula
public static function updateDocenteAula($aula_id, $docente_id)
{
    try {
        $db = new Database();

        // Verificar si el docente está disponible (no asignado a otra aula)
        $query = $db->connect()->prepare("SELECT COUNT(*) FROM docentes WHERE docente_id = :docente_id AND aula_id IS NULL");
        $query->bindParam(':docente_id', $docente_id, PDO::PARAM_INT);
        $query->execute();

        if ($query->fetchColumn() == 0) {
            return array('error' => true, 'message' => 'El docente seleccionado no está disponible.');
        }

        // Actualizar el aula_id del nuevo docente
        $query = $db->connect()->prepare("UPDATE docentes SET aula_id = :aula_id WHERE docente_id = :docente_id");
        $query->bindParam(':aula_id', $aula_id, PDO::PARAM_INT);
        $query->bindParam(':docente_id', $docente_id, PDO::PARAM_INT);
        $query->execute();

        return array('error' => false, 'message' => 'Docente actualizado correctamente.');
    } catch (PDOException $e) {
        return array('error' => true, 'message' => 'Error al actualizar el docente: ' . $e->getMessage());
    }
}


}
