<?php

require_once '../Docente.php';

use Letalandroid\controllers\Docente;

if (isset($_POST['createDocente'])) {
    header('Content-Type: application/json; charset=utf-8');

    try {
        $nombres = $_POST['nombres'];
        $apellidos = $_POST['apellidos'];
        $dni = $_POST['dni'];
        $genero = $_POST['genero'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
        $cursos_string = $_POST['cursos'];
        $cursos = explode(',', $cursos_string);

        $resultados = [];

        if (is_array($cursos)) {
            foreach ($cursos as $curso_id) {
                $add = Docente::create((int) $curso_id, $dni, $nombres, $apellidos, $genero, $fecha_nacimiento);

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
            echo json_encode('Docente agregado exitosamente');
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
