<?php

require_once '../../Conducta.php';

use Letalandroid\controllers\Conducta;

if (isset($_POST['createConducta'])) {
    header('Content-Type: application/json; charset=utf-8');

    try {

        $curso_id = $_POST['curso_id'];
        $unidad = $_POST['unidad'];
        $alumno_id = $_POST['alumno_id'];
        $calificacion = $_POST['calificacion'];
        $nota = $_POST['nota'];

        $search = Conducta::searchAll($alumno_id, $nota, $calificacion, $curso_id, $unidad);

        if ($search['error']) {
            http_response_code(500);
            echo json_encode(['Error al ejecutar la consulta', $search['message']]);
            exit();
        } else {

            if (sizeof($search) <= 0) {
                $add = Conducta::create($alumno_id, $nota, $calificacion, $curso_id, $unidad);

                if ($add['error']) {
                    http_response_code(500);
                    echo json_encode(['Error al ejecutar la consulta', $add['message']]);
                    exit();
                } else {
                    http_response_code(200);
                    echo json_encode('Nota agregado exitosamente');
                    exit();
                }
            } else {
                $edit = Conducta::edit($nota, $calificacion, $search[0]['conducta_id']);

                if ($edit['error']) {
                    http_response_code(500);
                    echo json_encode(['Error al ejecutar la consulta', $edit['message']]);
                    exit();
                } else {
                    http_response_code(200);
                    echo json_encode(['Nota editada exitosamente']);
                    exit();
                }
            }
        }

    } catch (Error $e) {
        http_response_code(500);
        echo json_encode(array('error' => true, 'message' => $e->getMessage()));
        exit();
    }
} else {
    http_response_code(500);
    echo json_encode(array('error' => true, 'message' => 'No se ha proporcion'));
}
