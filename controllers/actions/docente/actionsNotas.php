<?php

require_once '../../Notas.php';

use Letalandroid\controllers\Notas;

if (isset($_POST['createNota'])) {
    header('Content-Type: application/json; charset=utf-8');

    try {

        $alumno_id = $_POST['alumno_id'];
        $year = $_POST['year'];
        $unidad = $_POST['unidad'];
        $curso_id = $_POST['curso_id'];
        $tipo = $_POST['tipo'];
        $valor = $_POST['valor'];

        $search = Notas::searchAll($alumno_id, $year, $unidad, $curso_id, $tipo);

        if ($search['error']) {
            http_response_code(500);
            echo json_encode(['Error al ejecutar la consulta', $search['message']]);
            exit();
        } else {

            if (sizeof($search) <= 0) {
                $add = Notas::create($alumno_id, $year, $unidad, $curso_id, $tipo, $valor);

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
                $edit = Notas::edit($valor, $search[0]['nota_id']);

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
