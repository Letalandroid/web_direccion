<?php

use Letalandroid\controllers\Apoderado;
use Letalandroid\controllers\Asistencias;
use Letalandroid\controllers\Alumnos;
use Letalandroid\controllers\Agenda;
use Letalandroid\controllers\Notas;
use Letalandroid\controllers\Conducta;

require_once __DIR__ . '/../../../controllers/Apoderado.php';
require_once __DIR__ . '/../../../controllers/Asistencias.php';
require_once __DIR__ . '/../../../controllers/Alumnos.php';
require_once __DIR__ . '/../../../controllers/Agenda.php';
require_once __DIR__ . '/../../../controllers/Notas.php';
require_once __DIR__ . '/../../../controllers/Conducta.php';

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] != 'Apoderado') {
    header('Location: /');
    exit();
}

$apoderado_id = (int) ($_SESSION['apoderado_id'] ?? 0);

// Fetch apoderado and associated alumnos
$apoderado = Apoderado::getAllFormatId($apoderado_id) ?: [];
$alumnos = Alumnos::getAll_Apo($apoderado_id) ?: [];

// Initialize variables
$asistencias = [];
$cursos = [];
$actividades = [];
$promedios = [];
$descripcion_conducta = [];

if (!empty($alumnos)) {
    $alumno_id = $alumnos[0]['alumno_id'];

    // Fetch all required data for the first alumno
    $asistencias = Asistencias::getAll_Alumn($alumno_id) ?: [];
    $cursos = Notas::getAll_Aulm($alumno_id) ?: [];
    $promedios = Notas::getAverageByStudent($alumno_id) ?: [];
    $descripcion_conducta = Conducta::getconductaByAlumnoId($alumno_id, $apoderado_id) ?: [];

    if (!empty($cursos)) {
        $curso_id = $cursos[0]['curso_id'];
        $actividades = Agenda::getAll_Alumn($curso_id) ?: [];
    }
}

// Calculate attendance and absences
$asist = 0;
$faltas = 0;
foreach ($asistencias as $asistencia) {
    if ($asistencia['estado'] == 'Presente') {
        $asist++;
    } else {
        $faltas++;
    }
}

// Group activities by date
$eventos_por_fecha = [];
foreach ($actividades as $actividad) {
    $fecha_evento = $actividad['fecha_evento'];
    if (!isset($eventos_por_fecha[$fecha_evento])) {
        $eventos_por_fecha[$fecha_evento] = [];
    }
    $eventos_por_fecha[$fecha_evento][] = $actividad;
}

date_default_timezone_set('America/Bogota');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/views/apoderado/css/header.css" />
    <link rel="stylesheet" href="/views/apoderado/css/home.css" />
    <link rel="shortcut icon" href="/views/apoderado/assets/img/logo_transparent.png" type="image/x-icon" />
    <script defer src="/views/apoderado/js/home.js"></script>
    <script defer src="/views/apoderado/js/header.js"></script>
    <script defer>
        document.addEventListener('DOMContentLoaded', () => {
            closed_menu();
        });
    </script>
    <script src="https://kit.fontawesome.com/8b1c082df7.js" crossorigin="anonymous"></script>
    <title>I.E.P Los Clavelitos de SJT - Piura</title>
</head>

<body>
    <?php require_once __DIR__ . '/../components/header.php' ?>
    <main>
        <?php show_nav('Home') ?>
        <div class="container_izquierdo">
            <div>
                <img src="/views/apoderado/assets/img/FONDO_ANIMADO.png" alt="Imagen de Fondo">
            </div>
            <div class="sections__perfil">
                <p1>¡BIENVENIDO!</p1>
                <p2><?= !empty($apoderado) ? htmlspecialchars($apoderado[0]['nombres_apellidos']) : 'Apoderado' ?></p2>
                <div>
                    <img src="/views/apoderado/assets/img/PERFIL.png" alt="Imagen de perfil">
                </div>
            </div>
        </div>
        <div class="container_derecho">
            <div class="container_asistencia">
                <div>
                    <h2><a href="/views/apoderado/pages/asistencias.php">Asistencias:</a></h2>
                </div>
                <p class="<?= $faltas > $asist ? 'red' : 'green' ?>">
                    <?= $asist ?> / <?= count($asistencias) ?>
                </p>
                <h3><?= $faltas ?> días de falta</h3>
            </div>
            <div class="container__proxeventos">
                <h2><a href="/views/apoderado/pages/agenda.php">Próximos Eventos:</a></h2>
                <div>
                    <?php if (!empty($eventos_por_fecha)) {
                        foreach ($eventos_por_fecha as $fecha => $eventos) { ?>
                            <h4><?= $fecha == date('Y-m-d') ? 'Hoy' : htmlspecialchars($fecha) ?></h4>
                            <?php foreach ($eventos as $actividad) { ?>
                                <h5><?= htmlspecialchars($actividad['descripcion']) ?></h5>
                            <?php } ?>
                    <?php }
                    }else{ ?>
                    <h4>-</h4>
                    <h5>no hay agenda registrada</h5>
                      <?php } ?>
                </div>
            </div>
            <div class="container_conducta">
                <h2><a href="/views/apoderado/pages/conducta.php">Conducta:</a></h2>
                <?php if (!empty($descripcion_conducta)) {
                    foreach ($descripcion_conducta as $descripcion) { ?>
                        <p>
                        <h4><?= htmlspecialchars($descripcion['descripcion']) ?></h4>
                        </p>
                    <?php }
                } else { ?>
                    <p>No hay descripciones de conducta disponibles.</p>
                <?php } ?>
            </div>
            <div class="container_section_notas">
                <h2><a href="/views/apoderado/pages/notas.php">Mis notas:</a></h2>
                <div class="container__notas">
                    <?php if (!empty($promedios)) {
                        foreach ($promedios as $promedio) { ?>
                            <div class="section__notas">
                                <div>
                                    <i class="fas fa-book-open"></i>
                                    <h3><?= htmlspecialchars($promedio['nombre']) ?></h3>
                                </div>
                                <div>
                                    <p>Promedio General:</p>
                                    <p><?= isset($promedio['promedio']) ? number_format($promedio['promedio'], 2) : '0.00' ?></p>
                                </div>
                            </div>
                        <?php }
                    } else { ?>
                        <p>No hay notas disponibles.</p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </main>
</body>

</html>