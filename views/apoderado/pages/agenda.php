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
$cursos_compress = [];

foreach ($cursos as $curso) {
    $curso_id = $curso['curso_id'];
    if (!isset($cursos_compress[$curso_id])) {
        $cursos_compress[$curso_id] = $curso;
    }
}

foreach ($actividades as $actividad) {
    $fecha_evento = $actividad['fecha_evento'];

    if (!isset($eventos_por_fecha[$fecha_evento])) {
        $eventos_por_fecha[$fecha_evento] = [];
    }

    $eventos_por_fecha[$fecha_evento][] = $actividad;
}

$meses = [
    'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
    'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
];

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
                <select id="cursos">
                    <?php foreach ($cursos_compress as $curso) { ?>
                        <option value="<?= $curso['curso_id'] ?>"><?= $curso['nombre'] ?></option>
                    <?php } ?>
                </select>
                <h2>Agenda</h2>
                <select id="meses">
                    <option value="Todos">Todos</option>
                    <?php foreach ($meses as $mes) { ?>
                        <option value="<?= $mes ?>"><?= $mes ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="container__eventos">
                <?php foreach ($eventos_por_fecha as $evento) { ?>
                    <div class="eventos">
                        <h3>
                            <?php
                            $fecha_evento = $evento[0]['fecha_evento'];
                            $fecha_actual = date('Y-m-d');

                            if ($fecha_evento == $fecha_actual) {
                                echo 'Hoy';
                            } else {

                                $dia_evento = date('d', strtotime($fecha_evento));
                                $mes_numero = date('n', strtotime($fecha_evento));
                                $nombre_mes = $meses[$mes_numero - 1];
                                $ano_evento = date('Y', strtotime($fecha_evento));

                                echo "$dia_evento de $nombre_mes de $ano_evento";
                            }
                            ?>
                        </h3>
                        <?php foreach ($evento as $actividad) { ?>
                            <div class="evento">
                                <p><?= $actividad['descripcion'] ?></p>
                                <input type="checkbox">
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                <p style="display: none; text-align: center;" id="no_activity_container"></p>
            </div>
        </div>
    </main>
    <script>
        document.getElementById('meses').addEventListener('change', function() {
            let selectedMonth = this.value;
            let eventos = document.querySelectorAll('.eventos');
            const no_activity = document.querySelector('#no_activity_container');

            eventos.forEach(function(evento) {
                let fecha_evento = evento.querySelector('h3').textContent.trim();
                let mes_evento = fecha_evento.split(' ')[2];

                if (selectedMonth == 'Todos' || selectedMonth == mes_evento) {
                    evento.style.display = 'flex';
                    no_activity.style.display = 'none';
                    no_activity.innerHTML = '';
                } else {
                    evento.style.display = 'none';
                    no_activity.style.display = 'block';
                    no_activity.innerHTML = `¡No existen actividades para el es de <b>${selectedMonth}</b>!`;
                }
            });
        });
    </script>
</body>

</html>