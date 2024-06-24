<?php

require_once __DIR__ . '/../../../controllers/Docente.php';

$action = $_POST['action'] ?? null;

switch ($action) {
    case 'create':
        createDocente();
        break;
    case 'update':
        updateDocente();
        break;
    case 'delete':
        deleteDocente();
        break;
    case 'getById':
        getDocenteById();
        break;
    default:
        echo json_encode(['success' => false, 'message' => 'Acción no válida']);
}

function createDocente() {
    $dni = $_POST['dni'] ?? '';
    $nombres = $_POST['nombres'] ?? '';
    $apellidos = $_POST['apellidos'] ?? '';
    $rol = $_POST['rol'] ?? '';
    $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';
    $curso_id = $_POST['curso_id'] ?? '';
    $genero = $_POST['genero'] ?? '';

    if (Docente::create($dni, $nombres, $apellidos, $rol, $fecha_nacimiento, $curso_id, $genero)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al añadir docente']);
    }
}

function updateDocente() {
    $docente_id = $_POST['docente_id'] ?? 0;
    $dni = $_POST['dni'] ?? '';
    $nombres = $_POST['nombres'] ?? '';
    $apellidos = $_POST['apellidos'] ?? '';
    $rol = $_POST['rol'] ?? '';
    $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';
    $curso_id = $_POST['curso_id'] ?? '';
    $genero = $_POST['genero'] ?? '';

    if (Docente::update($docente_id, $dni, $nombres, $apellidos, $rol, $fecha_nacimiento, $curso_id, $genero)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar docente']);
    }
}

function deleteDocente() {
    $docente_id = $_POST['docente_id'] ?? 0;

    if (Docente::delete($docente_id)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar docente']);
    }
}

function getDocenteById() {
    $docente_id = $_POST['docente_id'] ?? 0;
    $docente = Docente::getById($docente_id);

    if ($docente) {
        echo json_encode(['success' => true, 'data' => $docente]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Docente no encontrado']);
    }
}
