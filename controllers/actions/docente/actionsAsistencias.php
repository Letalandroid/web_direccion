<?php

require_once '../../Asistencias.php';

use Letalandroid\controllers\Asistencias;

if (isset($_POST['getAsistencia'])) {
    header('Content-Type: application/json; charset=utf-8');

    try {

        $fecha = $_POST['fecha'];

        $get = Asistencias::getWithDate($fecha);

        if (isset($get['error'])) {
            http_response_code(500);
            echo json_encode('Error al ejecutar la consulta', $get['message']);
            exit();
        } else {
            http_response_code(200);
            echo json_encode($get);
            exit();
        }
    } catch (Error $e) {
        http_response_code(500);
        echo json_encode(array('error' => true, 'message' => $e->getMessage()));
        exit();
    }
} else if (isset($_POST['createAsistencia'])) {
    header('Content-Type: application/json; charset=utf-8');

    try {
        $alumno_id = $_POST['alumno_id'];
        $fecha_asistencia = $_POST['fecha_asistencia'];
        $estado = $_POST['estado'];
        $descripcion = $_POST['descripcion'];
        $curso_id = $_POST['curso_id'];

        $add = Asistencias::create($alumno_id, $fecha_asistencia, $estado, str_replace('//', ' ', $descripcion), $curso_id);

        if (isset($add['error'])) {
            http_response_code(500);
            echo json_encode(array('error' => true, 'message' => 'Error al ejecutar la consulta', 'details' => $add['message']));
            exit();
        } else {
            http_response_code(200);
            echo json_encode(array('message' => 'Asistencia agregada exitosamente'));
            exit();
        }
    } catch (Error $e) {
        http_response_code(500);
        echo json_encode(array('error' => true, 'message' => $e->getMessage()));
        exit();
    }
} else {
    http_response_code(500);
    echo json_encode(['error' => true, 'message' => 'Error en el servidor']);
}
