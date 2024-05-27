<?php

use Letalandroid\controllers\Agenda;
use Letalandroid\controllers\Alumnos;
use Letalandroid\controllers\Notas;

require_once __DIR__ . '/../../../controllers/Agenda.php';
require_once __DIR__ . '/../../../controllers/Alumnos.php';
require_once __DIR__ . '/../../../controllers/Notas.php';

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] != 'Apoderado') {
    header('Location: /');
    exit();
}

$alumno_id = Alumnos::getAll_Apo($_SESSION['apoderado_id'])[0]['alumno_id'];
$cursos =  Notas::getAll_Aulm($alumno_id);
$actividades = Agenda::getAll_Alumn($cursos[0]['curso_id']);
$eventos_por_fecha = [];

foreach ($actividades as $actividad) {
    $fecha_evento = $actividad['fecha_evento'];

    if (!isset($eventos_por_fecha[$fecha_evento])) {
        $eventos_por_fecha[$fecha_evento] = [];
    }

    $eventos_por_fecha[$fecha_evento][] = $actividad;
}

date_default_timezone_set('America/Bogota');

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/views/apoderado/css/header.css" />
    <link rel="stylesheet" href="/views/apoderado/css/agenda.css" />
    <link rel="shortcut icon" href="/views/apoderado/assets/img/logo_transparent.png" type="image/x-icon" />
    <script defer src="/views/apoderado/js/header.js"></script>
    <script defer src="/views/apoderado/js/agenda.js"></script>
    <script defer>
        document.addEventListener("DOMContentLoaded", () => {
            closed_menu();
        });
    </script>
    <script src="https://kit.fontawesome.com/8b1c082df7.js" crossorigin="anonymous"></script>
    <title>I.E.P Los Clavelitos de SJT - Piura | Agenda</title>
</head>

<body>
    <?php require_once __DIR__ . '/../components/header.php' ?>
    <main>
        <?php show_nav('Agenda'); ?>
        <div class="container__section">
            <div class="head">
                <select id="">
                    <?php foreach ($cursos as $curso) { ?>
                        <option value="<?= $curso['curso_id'] ?>"><?= $curso['nombre'] ?></option>
                    <?php } ?>
                </select>
                <h2>Agenda</h2>
            </div>
            <div class="container__eventos">
                <?php foreach ($eventos_por_fecha as $evento) { ?>
                    <div class="eventos">
                        <h3>
                            <?= $evento[0]['fecha_evento'] == date('Y-m-d') ? 'Hoy' : $evento[0]['fecha_evento'] ?>
                        </h3>
                        <?php foreach ($evento as $actividad) { ?>
                            <div class="evento">
                                <p><?= $actividad['descripcion'] ?></p>
                                <input type="checkbox">
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </main>
</body>

</html>