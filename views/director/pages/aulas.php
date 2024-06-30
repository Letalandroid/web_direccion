<?php

use Letalandroid\controllers\Aulas;

require_once __DIR__ . '/../../../controllers/Aulas.php';


session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] != 'Director') {
    header('Location: /');
    exit();
}
$error = [
    'status' => false,
    'message' => ''
];


$all_courses = Aulas::getAllAulasDocentes();

if (isset($all_courses['error'])) {
    $error['status'] = true;
    $error['message'] = $all_courses['message'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_aula'])) {
    $grado = $_POST['grado'];
    $seccion = $_POST['seccion'];
    $nivel = $_POST['nivel'];

    // Validar que la sección solo sea A, B, C o F
    if (!in_array($seccion, ['A', 'B', 'C', 'F'])) {
        $error['status'] = true;
        $error['message'] = 'La sección debe ser una de las siguientes letras: A, B, C, F';
    } else {
        $result = Aulas::addAula($grado, $seccion, $nivel);

        if (isset($result['error']) && $result['error'] === true) {
            $error['status'] = true;
            $error['message'] = $result['message'];

        } else {
            echo '<meta http-equiv="refresh" content="0">';
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="/views/director/css/header.css" />
	<link rel="stylesheet" href="/views/director/css/aulas.css" />
	<link rel="shortcut icon" href="/views/director/assets/img/logo_transparent.png" type="image/x-icon" />
	<script defer src="/views/director/js/header.js"></script>
	<script defer src="/views/director/js/aulas.js"></script>
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
        <?php show_nav('Aulas') ?>
        <div class="container__section">
            <div class="reload" id="reload" style="display: none;">
                <p id="reload_content">Parece que hay nuevos cambios, se sugiere <button onclick="location.reload();">recargar</button></p>
            </div>
            <div class="title__container">
                <h2>Aulas</h2>
            </div>
            <form method="POST">
                <div class="add__aula">
                    <label>Nivel:</label>
                    <select id="new_nivel" name="nivel" required onchange="updateGrades()">
                        <option value="" disabled selected>Seleccionar Nivel</option>
                        <option value="Inicial">Inicial</option>
                        <option value="Primaria">Primaria</option>
                    </select>
                    <label>Grado:</label>
                    <select id="new_grado" name="grado" required>
                        <option value="" disabled selected>Seleccionar Grado</option>
                    </select>
                    <label for="new_seccion">Sección:</label>
                    <input id="new_seccion" name="seccion" type="text" onkeydown="return soloLetras(event)" maxlength="50" placeholder="Sección" required oninput="validarLetras(this)">
                    <script src="/views/director/js/grados.js"></script>
                    <button id="btnAddAula" name="add_aula" type="submit">Agregar Aula</button>
                    <button type="button" class="btn btn-danger" onclick="window.location.href='/views/pdf/pages/director/pdfAulas.php';">Reporte PDF</button>
                </div>
            </form>
            <div class="container__notas">
            <?php foreach ($all_courses as $course) { ?>
                    <div class="course">
                        <span><a href="/views/director/pages/detalleAula.php?grado=<?= $course['grado'] ?>&seccion=<?= $course['seccion'] ?>&nivel=<?= $course['nivel'] ?>"><?= $course['grado'] ?>º <?= $course['seccion'] ?> de <?= $course['nivel'] ?></a></span>
                        <span><?= $course['docente'] ?? '<b>[Docente no asignado]</b>' ?></span>
                    </div>
                <?php } ?>
            </div>
        </div>
    </main>

    <script>
        function showReloadMessage() {
            document.getElementById('reload').style.display = 'block';
        }

        function updateGrades() {
            const gradoSelect = document.getElementById('new_grado');
            const nivelSelect = document.getElementById('new_nivel');
            const nivel = nivelSelect.value;

            // Limpiar las opciones actuales
            gradoSelect.innerHTML = '<option value="" disabled selected>Seleccionar Grado</option>';

            let options = [];
            if (nivel === 'Inicial') {
                options = [3, 4, 5];
            } else if (nivel === 'Primaria') {
                options = [1, 2, 3, 4, 5, 6];
            }

            // Añadir las nuevas opciones
            options.forEach(grado => {
                const option = document.createElement('option');
                option.value = grado;
                option.textContent = grado;
                gradoSelect.appendChild(option);
            });
        }
    </script>
</body>
</html>