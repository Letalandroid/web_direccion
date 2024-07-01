<?php

require_once __DIR__ . '/../../../controllers/Editarapoderado.php';

$action = $_POST['action'] ?? null;

switch ($action) {
    case 'create':
        createApoderado();
        break;
    case 'update':
        updateApoderado();
        break;
    case 'delete':
        deleteApoderado();
        break;
    case 'getById':
        getApoderadoById();
        break;
    default:
        echo json_encode(['success' => false, 'message' => 'Acción no válida']);
}


function getApoderadoById() {
    $apoderado_id = $_POST['apoderado_id'] ?? 0;
    $apoderado = Apoderado::getById($apoderado_id);

    if ($alumno) {
        echo json_encode(['success' => true, 'data' => $alumno]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Apoderado no encontrado']);
    }
}
function createAlumno() {
    $dni = $_POST['dni'] ?? '';
    $nombres = $_POST['nombres'] ?? '';
    $apellidos = $_POST['apellidos'] ?? '';
    $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';
    $apoderado_id = $_POST['apoderado_id'] ?? '';
    $genero = $_POST['genero'] ?? '';

    if (Alumno::create($dni, $nombres, $apellidos, $fecha_nacimiento, $apoderado_id, $genero)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al añadir alumno']);
    }
}

function updateAlumno() {
    $alumno_id = $_POST['alumno_id'] ?? 0;
    $dni = $_POST['dni'] ?? '';
    $nombres = $_POST['nombres'] ?? '';
    $apellidos = $_POST['apellidos'] ?? '';
    $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';
    $apoderado_id = $_POST['apoderado_id'] ?? '';
    $genero = $_POST['genero'] ?? '';
    $aula_id = $_POST['aula_id'] ?? 0;
    $grado = $_POST['grado'] ?? '';
    $seccion = $_POST['seccion'] ?? '';
    $nivel = $_POST['nivel'] ?? '';

    if (Alumno::update($alumno_id, $apoderado_id, $dni, $nombres, $apellidos, $genero, $fecha_nacimiento, $aula_id, $grado, $seccion, $nivel)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar alumno']);
    }
}

