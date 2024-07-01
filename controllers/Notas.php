<?php

namespace Letalandroid\controllers;

require_once __DIR__ . '/../model/db.php';

use Letalandroid\model\Database;
use Exception;
use PDO;
use PDOException;

class Notas
{

    static function getAll()
    {
        try {
            $db = new Database();

            $query = $db->connect()->prepare('select * from notas;');
            $query->execute();

            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (Exception $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
        }
    }

    static function searchAll($alumno_id, $year, $unidad, $curso_id, $tipo)
    {
        try {
            $db = new Database();

            $query = $db->connect()->prepare('select * from notas
            where curso_id=? and alumno_id=? and bimestre=? and tipo=? and year=?;');
            $query->bindValue(1, $curso_id, PDO::PARAM_INT);
            $query->bindValue(2, $alumno_id, PDO::PARAM_INT);
            $query->bindValue(3, $unidad, PDO::PARAM_INT);
            $query->bindValue(4, $tipo, PDO::PARAM_INT);
            $query->bindValue(5, $year, PDO::PARAM_INT);
            $query->execute();

            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (Exception $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
        }
    }

    static function getAll_Course_Conduct($curso_id)
    {
        try {
            $db = new Database();

            $query = $db->connect()->prepare('select a.alumno_id,concat(a.apellidos," ",a.nombres) as nombres_apellidos,
                                            n.*, c.* from notas n
                                            inner join alumnos a
                                            on (a.alumno_id=n.alumno_id)
                                            left join conducta c
                                            on (a.alumno_id=c.alumno_id)
                                            where n.curso_id=?;');
            $query->bindValue(1, $curso_id, PDO::PARAM_INT);
            $query->execute();

            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
        }
    }

    static function getAllFilter_Course($curso_id)
    {
        try {
            $db = new Database();

            $query = $db->connect()->prepare('select a.alumno_id,concat(a.apellidos," ",a.nombres) as nombres_apellidos,
                                            n.* from notas n
                                            inner join alumnos a
                                            on (a.alumno_id=n.alumno_id)
                                            where n.curso_id=?
                                            group by a.dni;');
            $query->bindValue(1, $curso_id, PDO::PARAM_INT);
            $query->execute();

            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
        }
    }

    static function getAll_Course($curso_id)
    {
        try {
            $db = new Database();

            $query = $db->connect()->prepare('select a.alumno_id,concat(a.apellidos," ",a.nombres) as nombres_apellidos,
                                            n.* from notas n
                                            inner join alumnos a
                                            on (a.alumno_id=n.alumno_id)
                                            where n.curso_id=?;');
            $query->bindValue(1, $curso_id, PDO::PARAM_INT);
            $query->execute();

            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
        }
    }

    static function getAll_Aulm($alumno_id)
    {
        try {
            $db = new Database();

            $query = $db->connect()->prepare('select c.curso_id, c.nombre, n.*
                                            from notas n
                                            inner join cursos c
                                            on (c.curso_id=n.curso_id)
                                            where alumno_id=?;');
            $query->bindValue(1, $alumno_id, PDO::PARAM_INT);
            $query->execute();

            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (Exception $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
        }
    }

    static function create($alumno_id, $year, $bimestre, $curso_id, $tipo, $valor)
    {
        try {
            $db = new Database();
            $query = $db->connect()->prepare('insert into notas (curso_id,alumno_id,bimestre,year,valor,tipo)
                                                values (?,?,?,?,?,?);');

            $query->bindValue(1, $curso_id, PDO::PARAM_INT);
            $query->bindValue(2, $alumno_id, PDO::PARAM_INT);
            $query->bindValue(3, $bimestre, PDO::PARAM_INT);
            $query->bindValue(4, $year, PDO::PARAM_INT);
            $query->bindValue(5, $valor, PDO::PARAM_INT);
            $query->bindValue(6, $tipo, PDO::PARAM_STR);
            $query->execute();

            return array('success' => true, 'message' => '✍️ Notas agregadas exitosamente');
        } catch (PDOException $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
            exit();
        }
    }

    static function edit($valor, $nota_id)
    {
        try {
            $db = new Database();
            $query = $db->connect()->prepare('update notas set valor=? where nota_id=?;');

            $query->bindValue(1, $valor, PDO::PARAM_INT);
            $query->bindValue(2, $nota_id, PDO::PARAM_INT);
            $query->execute();

            return array('success' => true, 'message' => '✍️ Notas agregadas exitosamente');
        } catch (PDOException $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
            exit();
        }
    }
    
    static function getAverageByStudent($alumno_id)
    {
        try {
            $db = new Database();

            $query = $db->connect()->prepare('
                SELECT c.curso_id, c.nombre, AVG(n.valor) as promedio
                FROM notas n
                INNER JOIN cursos c ON n.curso_id = c.curso_id
                WHERE n.alumno_id = ?
                GROUP BY c.curso_id, c.nombre
            ');
            $query->bindValue(1, $alumno_id, PDO::PARAM_INT);
            $query->execute();

            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (Exception $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
        }
    }

}

