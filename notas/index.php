<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="/css/header.css" />
		<link rel="stylesheet" href="/css/notas.css" />
		<script defer src="/components/header.js"></script>
		<script defer src="/components/nav.js"></script>
		<link
			rel="shortcut icon"
			href="/assets/img/logo_transparent.png"
			type="image/x-icon" />
		<script defer src="/js/header.js"></script>
		<script defer src="/js/notas.js"></script>
		<script defer>
			document.addEventListener('DOMContentLoaded', () => {
				nav('Notas');
				closed_menu();
			});
		</script>
		<script
			src="https://kit.fontawesome.com/8b1c082df7.js"
			crossorigin="anonymous"></script>
		<title>I.E.P Los Clavelitos de SJT - Piura</title>
	</head>
	<body>
		<main>
			<div class="container__section">
				<h2>Mis notas:</h2>
				<div class="container__notas"></div>
			</div>
		</main>
	</body>
</html>