<?php

use Letalandroid\controllers\Apoderado;

require_once __DIR__ . '/../../../controllers/Apoderado.php';

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] != 'Apoderado') {
	header('Location: /');
	exit();
}

$apoderado = Apoderado::getAllFormatId((int) $_SESSION['apoderado_id']);

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
				<p class="attendance-count">7/15</p>

				<h3>7 dias de faltas</h3>

			</div>
			<!-- contenedor proximos eventos (agenda) -->
			<div class="container__proxeventos">
				<h2><a href="/views/apoderado/pages/agenda.php">Proximos Eventos:</a></h2>
				<div>
					<h3>hoy:</h3>
					<p>Evaluacion: </p>
					<p>S2_Frameworks de CSS</p>

					<h3>16/04:</h3>
					<p>Evaluacion: </p>
					<p>S1_Listas y Tablas</p>
				</div>
			</div>
			<!-- contenedor conducta-->
			<div class="container_conducta">
				<h2><a href="/views/apoderado/pages/conducta.php">Conducta:</a></h2>
				<p>- El alumno responde de manera grosera a compañeros. Primer Aviso aviso</p>
				<p>- El alumno responde de manera grosera a compañeros. Segundo aviso</p>
			</div>
			<!-- contenedor notas -->
			<div class="container_section_notas">
				<h2><a href="views\apoderado\pages\notas.php">Mis notas:</a></h2>
				<button id="btn_left">
					<i class="fas fa-chevron-left"></i>
				</button>
				<div class="container__notas">
					<div class="section__notas">
						<div>
							<i class="fas fa-book-open"></i>
							<h3>Comunicación</h3>
						</div>
						<div>
							<p>Promedio:</p>
							<span>17.5</span>
						</div>
					</div>
					<div class="section__notas">
						<div>
							<i class="fas fa-book-open"></i>
							<h3>Ciencias:</h3>
						</div>
						<div style="background-color: #e2a300">
							<p>Promedio:</p>
							<span>11.3</span>
						</div>
					</div>
					<div class="section__notas">
						<div>
							<i class="fas fa-book-open"></i>
							<h3>Matemáticas:</h3>
						</div>
						<div style="background-color: #e20900">
							<p>Promedio:</p>
							<span>6.8</span>
						</div>
					</div>
					<div class="section__notas">
						<div>
							<i class="fas fa-book-open"></i>
							<h3>Geografía:</h3>
						</div>
						<div style="background-color: #e20900">
							<p>Promedio:</p>
							<span>8.2</span>
						</div>
					</div>
				</div>
				<button id="btn_right">
					<i class="fas fa-chevron-right"></i>
				</button>
			</div>
		</div>
	
	</main>
</body>

</html>
