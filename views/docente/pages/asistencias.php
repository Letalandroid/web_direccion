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

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/views/docente/css/header.css" />
    <link rel="stylesheet" href="/views/docente/css/asistencias.css" />
    <link rel="shortcut icon" href="/views/docente/assets/img/logo_transparent.png" type="image/x-icon" />
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
            <div class="container">
                <div class='container__courses'>
                <select value='id_curso'>
                <?php foreach ($cursos as $curso) { ?>
                    <option><?= $curso['nombre'] ?></option>
                <?php } ?>
                </select>
                </div>
                <div class='container__table'>
                <table>
                <thead>
                    <tr>
                    <td>Nombres y apellidos</td>
                    <td>Asistió</td>
                    <td>Faltó</td>
                    <td>Justificación</td>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($alumnos as $alumno) { ?>
                <tr>
                    <td><?= $alumno['nombres_apellidos'] ?></td>
                    <td class="btn"></td>
                    <td class="btn"></td>
                    <td class="btn"></td>
                </tr>
                <?php } ?>
                </tbody>
                </table>
            </div>
            </div>
    </main>
    </body>

</html>
