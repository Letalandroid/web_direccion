<?php

namespace Letalandroid\controllers;

require_once __DIR__ . '/../model/db.php';

use Letalandroid\model\Database;
use Exception;
use PDO;
use PDOException;

class Cita
{
    static function getAll()
    {
        try {
            $db = new Database();

            $query = $db->connect()->prepare('select * from citas;');
            $query->execute();

            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (Exception $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
        }
    }

    static function getAllApo_Id($apoderado_id)
    {
        try {
            $db = new Database();

            $query = $db->connect()->prepare('select * from citas where apoderado_id=?');
            $query->bindValue(1, $apoderado_id, PDO::PARAM_INT);
            $query->execute();

            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (Exception $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
        }
    }

    static function getApo_Id($apoderado_id)
    {
        try {
            $db = new Database();

            $query = $db->connect()->prepare('select * from citas where apoderado_id=? and visto=0;');
            $query->bindValue(1, $apoderado_id, PDO::PARAM_INT);
            $query->execute();

            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (Exception $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
        }
    }

    static function create($docente_id, $apoderado_id, $mensaje)
    {
        try {
            $db = new Database();
            $query = $db->connect()->prepare('INSERT INTO citas (docente_id, apoderado_id, mensaje, visto) VALUES (?,?,?,?);');

            $query->bindValue(1, $docente_id, PDO::PARAM_INT);
            $query->bindValue(2, $apoderado_id, PDO::PARAM_INT);
            $query->bindValue(3, $mensaje, PDO::PARAM_STR);
            $query->bindValue(4, false, PDO::PARAM_STR);
            $query->execute();

            return array('success' => true, 'message' => '📅 Cita agendada exitosamente');
        } catch (PDOException $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
        }
    }

    static function setView($cita_id)
    {
        try {
            $db = new Database();
            $query = $db->connect()->prepare('update citas set visto=true where cita_id=?');

            $query->bindValue(1, $cita_id, PDO::PARAM_INT);
            $query->execute();

            return array('success' => true, 'message' => '📅 Cita vista exitosamente');
        } catch (PDOException $e) {
            http_response_code(500);
            return array('error' => true, 'message' => 'Error en el servidor: ' . $e);
        }
    }
}
