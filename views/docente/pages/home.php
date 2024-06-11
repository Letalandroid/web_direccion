<?php

use Letalandroid\controllers\Docente;
use Letalandroid\controllers\Cursos;

require_once __DIR__ . '/../../../controllers/Docente.php';
require_once __DIR__ . '/../../../controllers/Cursos.php';

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] != 'Docente') {
	header('Location: /');
	exit();
}

$docente = Docente::getMinId($_SESSION['docente_id'])[0];
$cursos = Cursos::getForIdDoc($_SESSION['docente_id']);

?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="/views/docente/css/header.css" />
	<link rel="stylesheet" href="/views/docente/css/home.css" />
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=K2D:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
	<link rel="shortcut icon" href="/views/docente/assets/img/logo_transparent.png" type="image/x-icon" />
	<script defer src="/views/docente/js/home.js"></script>
	<script defer src="/views/docente/js/header.js"></script>
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
				<div class="profile__container">
					<div class="image__profile">
						<img class="bg_profile" src="/views/docente/assets/svg/bg_profile.svg" alt="background docente colors">
						<img class="profile_image" src="/views/docente/assets/svg/profile_image.svg" alt="profile image">
					</div>
					<div class="courses__asignated">
						<h3><?= $docente['nombres_apellidos'] ?></h3>
						<h4>Cursos asignados:</h4>
						<ul>
							<?php foreach ($cursos as $curso) { ?>
								<li>
									<a href="/docente/curso/<?= $curso['curso_id'] ?>"><?= $curso['nombre'] ?></a>
									<i class="fas fa-chevron-right"></i>
								</li>
							<?php } ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</main>
</body>

</html>