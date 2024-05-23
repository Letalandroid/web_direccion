<?php

require_once '../Agenda.php';

use Letalandroid\controllers\Agenda;

if (isset($_POST['createAgenda'])) {
    header('Content-Type: application/json; charset=utf-8');

    try {

        $curso_id = $_POST['curso_id'];
        $fecha_evento = $_POST['fecha_actividad'];
        $descripcion = $_POST['descripcion'];

        $add = Agenda::create($curso_id, $descripcion, $fecha_evento);

        if ($add['error']) {
            http_response_code(500);
            echo json_encode('Error al ejecutar la consulta', $add['message']);
            exit();
        } else {
            http_response_code(200);
            echo json_encode('Actividad agregado exitosamente');
            exit();
        }
    } catch (Error $e) {
        http_response_code(500);
        echo json_encode(array('error' => true, 'message' => $e->getMessage()));
        exit();
    }
} else {
    http_response_code(500);
}
