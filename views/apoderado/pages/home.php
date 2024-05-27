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
		<div>
			<div class="container__sections">
				<div class="sections__perfil">
					<p>Hola! <?= $apoderado[0]['nombres_apellidos'] ?></p>
				</div>
				<div class="container__section__notas">
					<h2><a href="/notas/">Mis notas:</a></h2>
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
		</div>
	</main>
</body>

</html>