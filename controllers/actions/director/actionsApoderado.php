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
        $telefono = $_POST['telefono'];
        $correo = $_POST['correo'];

        $add = Apoderado::create($dni, $nombres, $apellidos, $nacionalidad, $genero, $fecha_nacimiento, $telefono, $correo);

        if (isset($add['error'])) {
            http_response_code(500);
            echo json_encode('Error al ejecutar la consulta', $add['message']);
            exit();
        } else {

            $firstName = substr($nombres, 0, 3);
            $lenApellidos = strlen($apellidos);
            $lastName = substr($apellidos, $lenApellidos - 3, $lenApellidos);
            $dni_last = substr($dni, 5, 8);

            $username = $firstName . $lastName . $lenApellidos;
            $password = $firstName . $lastName . $dni_last;
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $apoderado_id = Apoderado::getAllLast()[0]['apoderado_id'];
            $create_user = Usuarios::createApoderado($apoderado_id, $username, $password_hash, 'Apoderado');

            if (isset($create_user['error'])) {
                http_response_code(500);
                echo json_encode('Error al ejecutar la consulta', $create_user['message']);
                exit();
            } else {
                http_response_code(200);
                echo json_encode('Apoderado agregado exitosamente');
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

if (isset($_POST['deleteApoderado'])) {
    header('Content-Type: application/json; charset=utf-8');
    try {
        $apoderado_id = $_POST['apoderado_id'];
        error_log('Eliminar apoderado_id: ' . $apoderado_id); 
        $delete = Apoderado::eliminar($apoderado_id);

        if ($delete['error']) {
            http_response_code(500);
            error_log('Error al eliminar el apoderado: ' . $delete['message']); 
            echo json_encode(array('error' => true, 'message' => 'Error al eliminar el apoderado: ' . $delete['message']));
            exit();
        } else {
            http_response_code(200);
            echo json_encode(array('success' => true, 'message' => 'Apoderado eliminado exitosamente'));
            exit();
        }
    } catch (Exception $e) {
        http_response_code(500);
        error_log('Error de servidor: ' . $e->getMessage()); 
        echo json_encode(array('error' => true, 'message' => $e->getMessage()));
        exit();
    }
} else {
    error_log('No se recibió deleteApoderado');
    echo json_encode(array('error' => true, 'message' => 'No se recibió deleteApoderado'));
    http_response_code(400);
    exit();
}
