<?php

require_once '../../Alumnos.php';
require_once '../../Notas.php';

use Letalandroid\controllers\Alumnos;
use Letalandroid\controllers\Notas;

if (isset($_POST['createAlumno'])) {
    header('Content-Type: application/json; charset=utf-8');

    try {
        $nombres = $_POST['nombres'];
        $apellidos = $_POST['apellidos'];
        $apoderado_dni = $_POST['apoderado_dni'];
        $dni = $_POST['dni'];
        $genero = $_POST['genero'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
        $aulas = $_POST['aula_id'];

        $add = Alumnos::create($apoderado_dni, $dni, $nombres, $apellidos, $genero, $fecha_nacimiento,$aulas);

        if (isset($add['error'])) {
            http_response_code(500);
            echo json_encode(array('error' => true, 'message' => 'Error al ejecutar la consulta', 'details' => $add['message']));
            exit();
        } else {

            $alumno_id = Alumnos::getAllReverse()[0]['alumno_id'];
            $cursos_array = explode(',', $cursos);

            if (is_array($cursos_array)) {
                foreach ($cursos_array as $curso_id) {
                    $addCourses = Notas::create($curso_id, $alumno_id, 1, date("Y"), 0);

                    if (isset($addCourses['error'])) {
                        http_response_code(500);
                        echo json_encode(array('error' => true, 'message' => 'Error al ejecutar la consulta', 'details' => $addCourses['message']));
                        exit();
                    }
                }
            }

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

if (isset($_POST['deleteAlumno'])) {
    header('Content-Type: application/json; charset=utf-8');
    try {
        $alumno_id = $_POST['alumno_id'];
        error_log('Eliminar alumno_id: ' . $alumno_id); 
        $delete = Alumnos::eliminar($alumno_id);

        if ($delete['error']) {
            http_response_code(500);
            error_log('Error al eliminar la actividad: ' . $delete['message']); 
            echo json_encode(array('error' => true, 'message' => 'Error al eliminar la actividad: ' . $delete['message']));
            exit();
        } else {
            http_response_code(200);
            echo json_encode(array('success' => true, 'message' => 'Alumno eliminado exitosamente'));
            exit();
        }
    } catch (Error $e) {
        http_response_code(500);
        error_log('Error de servidor: ' . $e->getMessage()); 
        echo json_encode(array('error' => true, 'message' => $e->getMessage()));
        exit();
    }
} else {
    error_log('No se recibió deleteAlumno');
    echo json_encode(array('error' => true, 'message' => 'No se recibió deleteAlumno'));
    http_response_code(400);
    exit();
}
 
