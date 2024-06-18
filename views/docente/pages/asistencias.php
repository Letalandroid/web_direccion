<?php

use Letalandroid\controllers\Cursos;
use Letalandroid\controllers\Alumnos;

require_once __DIR__ . '/../../../controllers/Cursos.php';
require_once __DIR__ . '/../../../controllers/Alumnos.php';


session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] != 'Docente') {
    header('Location: /');
    exit();
}

$alumnos = Alumnos::getAllMin();
$cursos = Cursos::getForIdDoc($_SESSION['docente_id']);
$year_now = date('Y');

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/views/docente/css/header.css" />
    <link rel="stylesheet" href="/views/docente/css/asistencias.css" />
    <link rel="shortcut icon" href="/views/docente/assets/img/logo_transparent.png" type="image/x-icon" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=K2D:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <script defer src="/views/docente/js/header.js"></script>
    <script defer>
        document.addEventListener("DOMContentLoaded", () => {
            closed_menu();
        });
    </script>
    <script src="https://kit.fontawesome.com/8b1c082df7.js" crossorigin="anonymous"></script>
    <title>I.E.P Los Clavelitos de SJT - Piura | Asistencias</title>
</head>

<body>
    <?php require_once __DIR__ . '/../components/header.php' ?>
    <main>
        <?php show_nav('Asistencias') ?>
        <?php require_once __DIR__ . '/../components/loader.php' ?>
        <div class="container">
            <div id="reload">
                <p>Parece que hay nuevos cambios, se sugiere <button onclick="location.reload();">recargar</button></p>
            </div>
            <div class="top">
                <div class='container__courses'>
                    <select onchange="cargarData(obtenerFecha())" id="id_curso">
                        <?php foreach ($cursos as $curso) { ?>
                            <option value="<?= $curso['curso_id'] ?>"><?= $curso['nombre'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="asist_top">
                <h1>Asistencia</h1>
                <div class="date_container">
                    <div class='date_input'>
                        <label>Fecha:</label>
                        <input onchange="cargarData(this.value)" type="date" id="year">
                    </div>
                    <div class="save_container">
                        <p>Guardar:</p>
                        <button class="save" onclick="enviarAsistencia()">
                            <img src="/views/docente/assets/svg/down.svg" alt="">
                        </button>
                    </div>
                </div>
                <div class="checked_container">
                    <button onclick="marcarAsistencia()">Marcar asistencia</button>
                    <button onclick="marcarFalta()">Marcar falta</button>
                </div>
            </div>
            <div class='container__table'>
                <div class="subcontainer__table">
                    <table>
                        <thead>
                            <tr>
                                <td rowspan="2">Alumno</td>
                                <td colspan="4">Asistencia</td>
                            </tr>
                            <tr>
                                <td>A</td>
                                <td>F</td>
                                <td>J</td>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <script src="/views/docente/js/asistencias.js"></script>
</body>

</html>