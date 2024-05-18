<?php

require_once '../Alumnos.php';

use Letalandroid\controllers\Alumnos;

if (isset($_POST['createAlumno'])) {
    header('Content-Type: application/json; charset=utf-8');

    try {
        $nombres = $_POST['nombres'];
        $apellidos = $_POST['apellidos'];
        $apoderado_dni = $_POST['apoderado_dni'];
        $dni = $_POST['dni'];
        $genero = $_POST['genero'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];

        $add = Alumnos::create($apoderado_dni, $dni, $nombres, $apellidos, $genero, $fecha_nacimiento);

        if (isset($add['error'])) {
            http_response_code(500);
            echo json_encode(array('error' => true, 'message' => 'Error al ejecutar la consulta', 'details' => $add['message']));
            exit();
        } else {
            http_response_code(200);
            echo json_encode(array('message' => 'Alumno agregado exitosamente'));
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
