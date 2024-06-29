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

$apoderado = Apoderado::getAllFormatId((int) $_SESSION['apoderado_id']);
$alumno_id = Alumnos::getAll_Apo((int) $_SESSION['apoderado_id'])[0]['alumno_id'];
$asistencias = Asistencias::getAll_Alumn($alumno_id);
$cursos = Notas::getAll_Aulm($alumno_id);
$actividades = Agenda::getAll_Alumn($cursos[0]['curso_id']);
$eventos_por_fecha = [];
$asist = 0;
$no_asist = 0;
$faltas = 0;

$descripcion_conducta = Conducta::getconductaByAlumnoId($alumno_id, $_SESSION['apoderado_id']);

foreach ($asistencias as $asistencia) {
    if ($asistencia['estado'] == 'Presente') {
        $asist++;
    } else {
        if ($asistencia['estado'] == 'Faltó') $faltas++;
        $no_asist++;
    }
}

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
		<!-- contenedor izquierdo -->
		<div class="container_izquierdo">
			<div>
				<img src="/views/apoderado/assets/img/FONDO_ANIMADO.png" alt="Imagen de Fondo">
			</div>
		
		<div class="sections__perfil">
			<p1>¡BIENVENIDO!</p1>
			<p2><?= $apoderado[0]['nombres_apellidos'] ?></p2>
			<div>
			<img src="/views/apoderado/assets/img/PERFIL.png" alt="Imagen de perfil">
			</div>
		</div>
		</div>



		<!-- contenedor derecho -->
		<div class="container_derecho">


			<!-- contenedor asistencias -->
			<div class="container_asistencia">
				<div>
					<h2><a href="/views/apoderado/pages/asistencias.php">Asistencias:</a></h2>
				</div>
				<p class="<?= $faltas > $asist ? 'red' : 'green' ?>">
                        <?= $asist ?> / <?= sizeof($asistencias) ?>
                    </p>

				<h3><?= $faltas ?> días de falta</h3>

			</div>
			<!-- contenedor proximos eventos (agenda) -->
           
			<div class="container__proxeventos">
            <h2><a href="/views/apoderado/pages/agenda.php">Proximos Eventos:</a></h2>
            <div>
            <?php foreach ($eventos_por_fecha as $evento) { ?>
					<h4><?= $evento[0]['fecha_evento'] == date('Y-m-d') ? 'Hoy' : $evento[0]['fecha_evento'] ?></h4>
					<?php foreach ($evento as $actividad) { ?>
                    <h5><?= $actividad['descripcion'] ?></h5>
                <?php } ?>
                <?php } ?>
            </div>
			</div>
            
			<!-- contenedor conducta-->
			<div class="container_conducta">
				<h2><a href="/views/apoderado/pages/conducta.php">Conducta:</a></h2>
				<?php if (!empty($descripcion_conducta)) {
                    foreach ($descripcion_conducta as $descripcion) { ?>
                        <p><h4><?= $descripcion['descripcion'] ?></h4>
                    <?php }
                } else { ?>
                    <p>No hay descripciones de conducta disponibles.</p>
                <?php } ?>
			</div>


<!-- contenedor notas -->
<div class="container_section_notas">
    <h2><a href="views/apoderado/pages/notas.php">Mis notas:</a></h2>
    <div class="container__notas">
        <?php foreach ($cursos as $curso) {
            // Obtener el promedio de notas para el curso actual
            $promedio = Notas::getAverageByApoderado($_SESSION['apoderado_id'], $alumno_id);

            // Mostrar los detalles del curso y el promedio de notas
        ?>
            <div class="section__notas">
                <div>
                    <i class="fas fa-book-open"></i>
                    <h3><?= $curso['nombre'] ?></h3>
                </div>
                <div>
                    <p>Promedio General:</p>
                    <span><?= isset($promedio['promedio']) ? $promedio['promedio'] : 'N/A' ?></span>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<!-- Aquí continúa el resto de tu HTML -->

</body>
</html>