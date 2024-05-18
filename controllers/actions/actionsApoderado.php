<?php

require_once '../Apoderado.php';

use Letalandroid\controllers\Apoderado;

if (isset($_POST['createApoderado'])) {
    header('Content-Type: application/json; charset=utf-8');

    try {
        $nombres = $_POST['nombres'];
        $apellidos = $_POST['apellidos'];
        $dni = $_POST['dni'];
        $genero = $_POST['genero'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
        $nacionalidad = $_POST['nacionalidad'];

        $add = Apoderado::create($dni, $nombres, $apellidos, $nacionalidad, $genero, $fecha_nacimiento);

        if (isset($add['error'])) {
            http_response_code(500);
            echo json_encode('Error al ejecutar la consulta', $add['message']);
            exit();
        } else {
            http_response_code(200);
            echo json_encode('Apoderado agregado exitosamente');
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
