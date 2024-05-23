<?php

require_once '../../Apoderado.php';
require_once '../../Usuarios.php';

use Letalandroid\controllers\Apoderado;
use Letalandroid\controllers\Usuarios;

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
            echo json_encode('Error al ejecutar la consulta');
            exit();
        } else {

            $firstName = substr($nombres, 0, 3);
            $lenApellidos = strlen($apellidos);
            $lastName = substr($apellidos, $lenApellidos - 3, $lenApellidos);
            $dni_last = substr($dni, 5, 8);

            $username = $firstName . $lastName . $lenApellidos;
            $password = $firstName . $lastName . $dni_last;
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $create_user = Usuarios::createApoderado($username, $password_hash, 'Apoderado');

            if (isset($create_user['error'])) {
                http_response_code(500);
                echo json_encode('Error al ejecutar la consulta', $create_user['message']);
                exit();
            } else {
                http_response_code(200);
                echo json_encode('Docente agregado exitosamente');
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
}
