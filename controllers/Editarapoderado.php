<?php

require_once __DIR__ . '/../../../controllers/Editarapoderado.php';

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


function getDocenteById() {
    $apoderado_id = $_POST['apoderado_id'] ?? 0;
    $apoderado = Apoderado::getById($apoderado_id);

    if ($docente) {
        echo json_encode(['success' => true, 'data' => $apoderado]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Apoderado no encontrado']);
    }
}
