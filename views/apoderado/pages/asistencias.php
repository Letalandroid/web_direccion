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
        if ($asistencia['estado'] == 'Faltó') $faltas++;
        $no_asist++;
    }
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
            <div class="desc__container">
                <div class="desc__modal">
                    <h3>Justificación</h3>
                    <p></p>
                    <div class="closed_msg">
                        <button onclick="closed()">Cerrar</button>
                    </div>
                </div>
            </div>
            <div>
                <div class="section__asistencias">
                    <h2>Asistencias</h2>
                    <p class="<?= $faltas > $asist ? 'red' : 'green' ?>">
                        <?= $asist ?> / <?= sizeof($asistencias) ?>
                    </p>
                    <span><?= $faltas ?> días de falta</span>
                </div>
            </div>
            <div>
                <select id="selectMes">
                    <option value="">Todos</option>
                    <?php foreach ($meses as $index => $mes) { ?>
                        <option value="<?= $index + 1 ?>"><?= $mes ?></option>
                    <?php } ?>
                </select>
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
                                <td id="date_<?= $asistencia['asistencia_id'] ?>">
                                    <?= $asistencia['fecha_asistencia'] == date('Y-m-d') ?
                                        'Hoy' : $asistencia['fecha_asistencia'] ?></td>
                                <td>
                                    <span onclick="showJustify('a_<?= $asistencia['asistencia_id'] ?>')" class="<?= substr($asistencia['estado'], 0, 1) ?>">
                                        <?= $asistencia['estado'] ?>
                                    </span>
                                    <?php if ($asistencia['descripcion'] != '') { ?>
                                        <span id="desc_<?= $asistencia['asistencia_id'] ?>" hidden class="asistencia__desc">
                                            <?= $asistencia['descripcion'] ?>
                                        </span>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <script>
        const selectMes = document.getElementById('selectMes');
        const desc__container = document.querySelector('.desc__container');

        selectMes.addEventListener('change', function() {
            const mesSeleccionado = selectMes.value;

            const filasAsistencias = document.querySelectorAll('.section__table tbody tr');

            filasAsistencias.forEach(function(fila) {
                const fechaAsistencia = fila.querySelector('td:first-child').innerText.trim();

                const fecha = new Date(fechaAsistencia);
                const mes = fecha.getMonth() + 1;

                if (mesSeleccionado === '' || parseInt(mesSeleccionado) === mes) {
                    fila.style.display = 'table-row';
                } else {
                    fila.style.display = 'none';
                }
            });
        });

        const showJustify = (j) => {
            const desc = document.querySelector(`#desc_${j.split('a_')[1]}`).innerHTML;
            const date = document.querySelector(`#date_${j.split('a_')[1]}`).innerHTML;;
            setJustify(desc, date);
        }

        const setJustify = (desc, date) => {
            desc__container.querySelector('h3').innerHTML = `Justificación - ${date}`;
            desc__container.querySelector('p').innerHTML = desc;
            desc__container.style.display = 'flex';
        }

        const closed = () => {
            desc__container.style.display = 'none';
        }
    </script>
</body>

</html>