<?php

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] != 'Docente') {
	header('Location: /');
	exit();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="/views/docente/css/header.css" />
	<link rel="stylesheet" href="/views/docente/css/notas.css" />
	<link rel="shortcut icon" href="/views/docente/assets/img/logo_transparent.png" type="image/x-icon" />
	<script defer src="/views/docente/js/header.js"></script>
	<script defer src="/views/docente/js/notas.js"></script>
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
        <?php show_nav('Notas') ?>
        <div class="container__section">
            <div class="header">
                <h2>NOTAS</h2>
                <div class="form-row">
                    <div class="form-group">
                        <label for="curso">Curso:</label>
                        <select id="curso" name="curso">
                            <option value="">Seleccionar curso</option>
                            <!-- Add options here -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="alumno">Unidad:</label>
                        <select id="alumno" name="alumno">
                            <option value="">Seleccionar unidad</option>
                            <!-- Add options here -->
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="unidad">Alumno:</label>
                        <select id="unidad" name="unidad">
                            <option value="">Seleccionar Alumno</option>
                            <!-- Add options here -->
                        </select>
                    </div>
                    <button id="buscar">Buscar</button>
                    <button id="guardar"><i class="fas fa-download"></i> Guardar</button>
                </div>
            </div>
			<style>
			.notas-table {
				border: 1px solid #ccc; /* color del borde */
				border-collapse: collapse;
				border-radius: 10px; /* valor de radio de curvatura */
				overflow: hidden;
			}
			.notas-table thead th,.notas-table tbody td {
				border-radius: 10px; /* valor de radio de curvatura */
				}
			</style>

            <table class="notas-table">
                <thead>
                    <tr>
                        <th>Bimestre</th>
                        <th>Notas</th>
                        <th>Limpiar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Practica</td>
                        <td><input type="text" class="nota-input"></td>
                        <td><button class="delete-btn"><i class="fas fa-trash"></i></button></td>
                    </tr>
                    <tr>
                        <td>Participacion</td>
                        <td><input type="text" class="nota-input"></td>
                        <td><button class="delete-btn"><i class="fas fa-trash"></i></button></td>
                    </tr>
                    <tr>
                        <td>Examen</td>
                        <td><input type="text" class="nota-input"></td>
                        <td><button class="delete-btn"><i class="fas fa-trash"></i></button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>