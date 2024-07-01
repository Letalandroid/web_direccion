<?php

use Letalandroid\controllers\Aulas;

require_once __DIR__ . '/../../../controllers/Aulas.php';


session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] != 'Director') {
    header('Location: /');
    exit();
}

$error = [
    'status' => false,
    'message' => ''
];

$grado = $_GET['grado'] ?? null;
$seccion = $_GET['seccion'] ?? null;
$nivel = $_GET['nivel'] ?? null;

if (!$grado || !$seccion || !$nivel) {
    $error['status'] = true;
    $error['message'] = 'Parámetros inválidos para mostrar detalle del aula.';
}

// Obtener todos los datos del docente para el aula específica
$docente = Aulas::getDocenteAula($grado, $seccion, $nivel);

// Obtener todos los alumnos del aula específica
$alumnos = Aulas::getAlumnosAula($grado, $seccion, $nivel);

// Obtener todos los docentes disponibles que no tienen aulas asignadas
$docentes_disponibles = Aulas::getDocentesDisponibles();

// Procesar el formulario de cambio de docente
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['docente_id'])) {
    $docente_id = $_POST['docente_id'];

    $result = Aulas::updateDocenteAula($docente['aula_id'], $docente_id);

    if ($result['error']) {
        $error['status'] = true;
        $error['message'] = $result['message'];
    } else {
        // Actualizar la información del docente después del cambio
        $docente = Aulas::getDocenteAula($grado, $seccion, $nivel);
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="/views/director/css/header.css" />
	<link rel="stylesheet" href="/views/director/css/detalleAula.css" />
	<link rel="shortcut icon" href="/views/director/assets/img/logo_transparent.png" type="image/x-icon" />
	<script defer src="/views/director/js/header.js"></script>
	<script defer src="/views/director/js/aulas.js"></script>
	<script defer>
		document.addEventListener('DOMContentLoaded', () => {
			closed_menu();
		});
	</script>
	<script src="https://kit.fontawesome.com/8b1c082df7.js" crossorigin="anonymous"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	<title>I.E.P Los Clavelitos de SJT - Piura</title>
</head>

<body>
    <?php if ($error['status']) { ?>
        <div class="alert alert-danger alert-dismissible fade show m-2" role="alert">
            <strong>❌ Error:</strong> <?= $error['message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php } ?>
    <?php require_once __DIR__ . '/../components/header.php' ?>
    <main>
        <div class="menu-container">
            <?php show_nav('Aulas') ?>
        </div>
        <div class="content-container">
            <div class="container__section">
                <h2 style="text-align: center;">Detalle del Aula: <?= $grado ?>º <?= $seccion ?> de <?= $nivel ?></h2>
                <?php if (!empty($docente)) { ?>
                    <div class="card mt-4 centered-card">
                        <div class="tituloD">
                            <h3 style="text-align: center;">Docente a cargo</h3>
                        </div>
                        <div class="card-body docente-info">
                            <div class="row">
                                <div class="col-md-4"><p><strong>Nombre:</strong> <?= $docente['nombres'] ?> <?= $docente['apellidos'] ?></p></div>
                                <div class="col-md-4"><p><strong>DNI:</strong> <?= $docente['dni'] ?></p></div>
                                <div class="col-md-4"><p><strong>Género:</strong> <?= $docente['genero'] ?></p></div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"><p><strong>Fecha de Nacimiento:</strong> <?= $docente['fecha_nacimiento'] ?></p></div>
                                <div class="col-md-4"><p><strong>Correo:</strong> <?= $docente['correo'] ?></p></div>
                                <div class="col-md-4"><p><strong>Teléfono:</strong> <?= $docente['telefono'] ?></p></div>
                            </div>
                        </div>
                    </div>
                    <!-- Mostrar tabla de alumnos -->
                    <div class="card mt-4 centered-card">
                        <div class="tituloA">
                            <h3 style="text-align: center;">Alumnos del Aula</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped alumnos-table">
                                <thead>
                                    <tr>
                                        <th>DNI</th>
                                        <th>Nombres</th>
                                        <th>Apellidos</th>
                                        <th>Género</th>
                                        <th>Fecha de Nacimiento</th>
                                        <th>Apoderado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($alumnos as $alumno) { ?>
                                        <tr>
                                            <td><?= $alumno['dni'] ?></td>
                                            <td><?= $alumno['nombres'] ?></td>
                                            <td><?= $alumno['apellidos'] ?></td>
                                            <td><?= $alumno['genero'] ?></td>
                                            <td><?= $alumno['fecha_nacimiento'] ?></td>
                                            <td><?= $alumno['apoderado_nombres'] ?> <?= $alumno['apoderado_apellidos'] ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php } else { ?>
                    <p style="text-align: center;">No se encontró un docente asignado para este aula.</p>
                <?php } ?>
            </div>
        </div>
    </main>
    

</body>
</html>