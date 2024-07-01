<?php

require_once '../../Cita.php';
require_once '../../Apoderado.php';

use Letalandroid\controllers\Apoderado;
use Letalandroid\controllers\Cita;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['createCita'])) {
        header('Content-Type: application/json; charset=utf-8');

        try {
            $docente_id = $_POST['docente_id'];
            $apoderado_dni = $_POST['apoderado_dni'];
            $mensaje = $_POST['mensaje'];
            $apoderado_id = Apoderado::getId($apoderado_dni)[0]['apoderado_id'];

            $add = Cita::create($docente_id, $apoderado_id, $mensaje);

            if ($add['error']) {
                http_response_code(500);
                echo json_encode(array('error' => true, 'message' => 'Error al ejecutar la consulta', 'details' => $add['message']));
                exit();
            } else {
                http_response_code(200);
                echo json_encode(array('success' => true, 'message' => 'Cita enviada exitosamente'));
                exit();
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(array('error' => true, 'message' => $e->getMessage()));
            exit();
        }
    } else  if (isset($_POST['setView'])) {
        header('Content-Type: application/json; charset=utf-8');

        try {

            $cita_id = $_POST['cita_id'];

            $view = Cita::setView($cita_id);

            if ($view['error']) {
                http_response_code(500);
                echo json_encode(array('error' => true, 'message' => 'Error al ejecutar la consulta', 'details' => $view['message']));
                exit();
            } else {
                http_response_code(200);
                echo json_encode(array('success' => true, 'message' => 'Cita enviada exitosamente'));
                exit();
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(array('error' => true, 'message' => $e->getMessage()));
            exit();
        }
    }
} else {
    http_response_code(405);
    echo json_encode(array('error' => true, 'message' => 'Método no permitido'));
    exit();
}
