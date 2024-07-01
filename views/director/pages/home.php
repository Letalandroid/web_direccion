<?php

use Letalandroid\controllers\Usuarios;

require_once __DIR__ . '/../../../controllers/Usuarios.php';

session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['rol'] != 'Director') {
	header('Location: /');
	exit();
}

$getName = Usuarios::getWithIdDoc($_SESSION['docente_id'])[0]['nombres_apellidos'];

?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="/views/director/css/header.css" />
	<link rel="stylesheet" href="/views/director/css/home.css" />
	<link rel="shortcut icon" href="/views/director/assets/img/logo_transparent.png" type="image/x-icon" />
	<script defer src="/views/director/js/home.js"></script>
	<script defer src="/views/director/js/header.js"></script>
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
		<div class="container">
        <div class="header">
            <img src="/views/director/assets/img/usuario.png" alt="Imagen de Persona" class="profile-img">
            <div class="user-info">
                <h2><?= $getName ?></h2>
                <p><?= $_SESSION['rol'] ?></p>
            </div>
        </div>
        <div class="cards">
            <div class="card">
			<img src="/views/director/assets/img/personas.png" alt="Imagen de Persona" class="profile-img">
                <h3>Lista Docentes</h3>
                <button class="btn btn-red">→</button>
            </div>
            <div class="card">
			<img src="/views/director/assets/img/personas.png" alt="Imagen de Persona" class="profile-img">
                <h3>Lista Alumnos</h3>
                <button class="btn btn-blue">→</button>
            </div>
            <div class="card">
			<img src="/views/director/assets/img/personas.png" alt="Imagen de Persona" class="profile-img">
                <h3>Administración</h3>
				<button class="btn btn-orange">→</button>
            </div>
        </div>
    </div>
	</main>
</body>

</html>