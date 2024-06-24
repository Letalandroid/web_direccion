<?php

require_once '../../Agenda.php';

use Letalandroid\controllers\Agenda;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['createAgenda'])) {
        header('Content-Type: application/json; charset=utf-8');
    
        try {
            $curso_id = $_POST['curso_id'];
            $fecha_evento = $_POST['fecha_actividad'];
            $descripcion = $_POST['descripcion'];
    
            $add = Agenda::create($curso_id, $descripcion, $fecha_evento);
    
            if ($add['error']) {
                http_response_code(500);
                echo json_encode('Error al ejecutar la consulta', $add['message']);
                exit();
            } else {
                http_response_code(200);
                echo json_encode('Actividad agregado exitosamente');
                exit();
            }
        } catch (Error $e) {
            http_response_code(500);
            echo json_encode(array('error' => true, 'message' => $e->getMessage()));
            exit();
        }
    }if (isset($_POST['updateAgenda'])) {
        $evento_id = $_POST['evento_id'];
        $curso_id = $_POST['curso_id'];
        $descripcion = $_POST['descripcion'];
        $fecha_evento = $_POST['fecha_evento'];
    
        try {
            $update = Agenda::actualizar($evento_id, $curso_id, $descripcion, $fecha_evento);
    
            if ($update['error']) {
                http_response_code(500);
                echo json_encode(array('error' => true, 'message' => 'Error al actualizar la actividad: ' . $update['message']));
                exit();
            } else {
                http_response_code(200);
                echo json_encode(array('success' => true, 'message' => 'Actividad actualizada exitosamente'));
                exit();
            }
        } catch (Error $e) {
            http_response_code(500);
            echo json_encode(array('error' => true, 'message' => $e->getMessage()));
            exit();
        }
    }
    
    if (isset($_POST['deleteAgenda'])) {
        try {
            $evento_id = $_POST['evento_id'];
            error_log('Eliminar evento_id: ' . $evento_id); 
            echo json_encode(array('message' => 'Intentando eliminar el evento con ID: ' . $evento_id)); 

            $delete = Agenda::eliminar($evento_id);

            if ($delete['error']) {
                http_response_code(500);
                error_log('Error al eliminar la actividad: ' . $delete['message']); 
                echo json_encode(array('error' => true, 'message' => 'Error al eliminar la actividad: ' . $delete['message']));
                exit();
            } else {
                http_response_code(200);
                echo json_encode(array('success' => true, 'message' => 'Actividad eliminada exitosamente'));
                exit();
            }
        } catch (Error $e) {
            http_response_code(500);
            error_log('Error de servidor: ' . $e->getMessage()); 
            echo json_encode(array('error' => true, 'message' => $e->getMessage()));
            exit();
        }
    } 

    http_response_code(400);
    echo json_encode(array('error' => true, 'message' => 'No se ha proporcionado una acción válida'));
    exit();
} else {
    http_response_code(405);
    echo json_encode(array('error' => true, 'message' => 'Método no permitido'));
    exit();
}

?>


