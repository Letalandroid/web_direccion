<?php

require_once '../../Cursos.php';

use Letalandroid\controllers\Cursos;

if (isset($_POST['createCurso'])) {
    header('Content-Type: application/json; charset=utf-8');

    try {
        $nombre = $_POST['nombre'];

        $add = Cursos::create($nombre);

        if ($add['error']) {
            http_response_code(500);
            echo json_encode('Error al ejecutar la consulta', $add['message']);
            exit();
        } else {
            http_response_code(200);
            echo json_encode('Curso agregado exitosamente');
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
