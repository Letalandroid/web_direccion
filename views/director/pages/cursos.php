<?php

use Letalandroid\controllers\Cursos;

require_once __DIR__ . '/../../../controllers/Cursos.php';

session_start();
if (!isset($_SESSION['user_id']) && $_SESSION['rol'] != 'Director') {
	header('Location: /');
	exit();
}
$error = [
	'status' => false,
	'message' => ''
];

$all_courses = Cursos::getAll_Docente();

if (isset($all_courses['error'])) {
	$error['status'] = true;
	$error['message'] = $all_courses['message'];
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="/views/director/css/header.css" />
	<link rel="stylesheet" href="/views/director/css/cursos.css" />
	<link rel="shortcut icon" href="/views/director/assets/img/logo_transparent.png" type="image/x-icon" />
	<script defer src="/views/director/js/header.js"></script>
	<script defer src="/views/director/js/cursos.js"></script>
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
		<?php show_nav('Cursos') ?>
		<div class="container__section">
			<div class="reload">
				<p id="reload_content">Parece que hay nuevos cambios, se sugiere <button onclick="location.reload();">recargar</button></p>
			</div>
			<div class="title__container">
				<h2>Cursos:</h2>
				<button onclick="mostrar()" id="btn_show_add"><i class="fa fa-plus"></i></button>
			</div>
			<div class="add__course">
				<label>Nombre del curso:</label>
				<input id="new_course" type="text" placeholder="<?= $all_courses[0]['curso'] ?>">
				<button id="btnAdd">Agregar</button>
			</div>
			<div class="container__notas">
				<?php foreach ($all_courses as $course) { ?>
					<div class="course">
						<span><?= $course['curso'] ?></span>
						<span><?= $course['docente'] ?? '<b>[Docente no asignado]</b>' ?></span>
					</div>
				<?php } ?>
			</div>
		</div>
	</main>
</body>

</html>