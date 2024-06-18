<?php

require_once '../../Asistencias.php';
require_once '../../Notas.php';

use Letalandroid\controllers\Notas;
use Letalandroid\controllers\Asistencias;

if (isset($_POST['getAsistencia'])) {
    header('Content-Type: application/json; charset=utf-8');

    $fecha = $_POST['fecha'];
    $curso_id = $_POST['curso_id'];

    try {

        $alumnos = Notas::getAll_Course($curso_id);

        if (isset($alumnos['error'])) {
            http_response_code(500);
            echo json_encode(['message' => 'Error al ejecutar la consulta', $alumnos['message']]);
            exit();
        } else {
            $asistencias = Asistencias::getWithDate($fecha, $curso_id);

            if (isset($asistencias['error'])) {
                http_response_code(500);
                echo json_encode(['message' => 'Error al ejecutar la consulta', $asistencias['message']]);
                exit();
            } else {
                http_response_code(200);
                echo json_encode([$alumnos, $asistencias, $fecha]);
                exit();
            }
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

        $isUpdate = Asistencias::getForUpdate($alumno_id, $fecha_asistencia, $curso_id);

        if (sizeof($isUpdate) >= 1 && !isset($isUpdate['error'])) {
            $add = Asistencias::update($alumno_id, $fecha_asistencia, $estado, str_replace('//', ' ', $descripcion), $curso_id);

            if (isset($add['error'])) {
                http_response_code(500);
                echo json_encode(array('error' => true, 'message' => 'Error al ejecutar la consulta', 'details' => $add['message']));
                exit();
            } else {
                http_response_code(200);
                echo json_encode(array('message' => 'Asistencia actualizada exitosamente', 'estado' => $estado));
                exit();
            }
        } else {
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
