<?php

require_once '../Cursos.php';

use Letalandroid\controllers\Cursos;

if (isset($_POST['createCurso'])) {
    header('Content-Type: application/json; charset=utf-8');

    try {
        $nombre = $_POST['nombre'];

        $resultados = [];

        if (is_array($cursos)) {
            foreach ($cursos as $curso_id) {
                $add = Cursos::create($nombre);

                if (!isset($add['error'])) {
                    array_push($resultados, 1);
                } else {
                    array_push($resultados, 0);
                }
            }
        }

        if (array_filter($resultados) == 0 || empty($resultados)) {
            http_response_code(500);
            echo json_encode('Error al ejecutar la consulta');
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
