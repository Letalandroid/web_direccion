<?php

use Letalandroid\controllers\Asistencias;
use Letalandroid\controllers\Alumnos;

require_once __DIR__ . '/../../../controllers/Asistencias.php';
require_once __DIR__ . '/../../../controllers/Alumnos.php';

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] != 'Apoderado') {
    header('Location: /');
    exit();
}

$alumno_id = Alumnos::getAll_Apo((int) $_SESSION['apoderado_id'])[0]['alumno_id'];
$asistencias = Asistencias::getAll_Alumn($alumno_id);
$asist = 0;
$no_asist = 0;
$faltas = 0;

foreach ($asistencias as $asistencia) {
    if ($asistencia['estado'] == 'Presente') {
        $asist++;
    } else {
        if ($asistencia['estado'] == 'Faltó') $faltas ++;
        $no_asist++;
    }
}

date_default_timezone_set('America/Bogota');

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/views/apoderado/css/header.css" />
    <link rel="stylesheet" href="/views/apoderado/css/asistencias.css" />
    <link rel="shortcut icon" href="/views/apoderado/assets/img/logo_transparent.png" type="image/x-icon" />
    <script defer src="/views/apoderado/js/header.js"></script>
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
        <div class="container__section">
            <div>
                <div class="section__asistencias">
                    <h2>Asistencias</h2>
                    <p class="<?= $faltas > $asist ? 'red' : 'green' ?>">
                        <?= $asist ?> / <?= sizeof($asistencias) ?>
                    </p>
                    <span><?= $faltas ?> días de falta</span>
                </div>
            </div>
            <div class="section__table">
                <table>
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($asistencias as $asistencia) { ?>
                            <tr>
                                <td><?= $asistencia['fecha_asistencia'] == date('Y-m-d') ?
                                'Hoy' : $asistencia['fecha_asistencia'] ?></td>
                                <td>
                                    <span class="<?= substr($asistencia['estado'], 0, 1) ?>"><?= $asistencia['estado'] ?></span>
                                    <?php if ($asistencia['descripcion'] != '') { ?>
                                        <button onclick="alert('<?= $asistencia['descripcion'] ?>')">Ver</button>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>

</html>