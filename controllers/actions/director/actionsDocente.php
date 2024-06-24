<?php

require_once '../../Docente.php';
require_once '../../Usuarios.php';

use Letalandroid\controllers\Docente;
use Letalandroid\controllers\Usuarios;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
if (isset($_POST['createDocente'])) {
    header('Content-Type: application/json; charset=utf-8');

    try {
        
        $dni = $_POST['dni'];
        $nombres = $_POST['nombres'];
        $apellidos = $_POST['apellidos'];
        $rol = $_POST['rol'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
        $curso_id = $_POST['curso_id'];
        $genero = $_POST['genero'];
       
        $cursos = explode(',', $cursos_string);

        $resultados = [];

        if (is_array($cursos)) {
            foreach ($cursos as $curso_id) {
                $add = Docente::create((int) $dni, $nombres, $apellidos, $rol, $fecha_nacimiento, $curso_id, $genero);

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

            $firstName = substr($nombres, 0, 3);
            $lenApellidos = strlen($apellidos);
            $lastName = substr($apellidos, $lenApellidos - 3, $lenApellidos);
            $dni_last = substr($dni, 5, 8);

            $username = $firstName . $lastName . $lenApellidos;
            $password = $firstName . $lastName . $dni_last;
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $docente_id = Docente::getAllLast()[0]['docente_id'];

            $create_user = Usuarios::createDocente($docente_id, $username, $password_hash, 'Docente');

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
}