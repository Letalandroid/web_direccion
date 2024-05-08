<?php

session_start();
if (!isset($_SESSION['user_id']) && $_SESSION['rol'] != 'Director') {
	header('Location: /');
	exit();
}

$username = $_SESSION['username'];

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
		<div>
			<div class="container__sections">
				<div class="sections__perfil">
					<p>Hola! <?= $username ?></p>
				</div>
			</div>
		</div>
	</main>
</body>

</html>