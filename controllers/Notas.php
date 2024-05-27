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

    static function getAll_Aulm($alumno_id)
    {
        try {
            $db = new Database();

            $query = $db->connect()->prepare('select c.curso_id, c.nombre
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

    static function create($curso_id, $alumno_id, $bimestre, $year, $valor)
    {
        try {
            $db = new Database();
            $query = $db->connect()->prepare('insert into notas (curso_id,alumno_id,bimestre,year,valor)
                                                values (?,?,?,?,?);');

            $query->bindValue(1, $curso_id, PDO::PARAM_INT);
            $query->bindValue(2, $alumno_id, PDO::PARAM_INT);
            $query->bindValue(3, $bimestre, PDO::PARAM_INT);
            $query->bindValue(4, $year, PDO::PARAM_INT);
            $query->bindValue(5, $valor, PDO::PARAM_INT);
            $query->execute();

            return array('success' => true, 'message' => '✍️ Notas agregadas exitosamente');
        } catch (PDOException $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
            exit();
        }
    }
}
