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
            <div class="top">
                <div class='container__courses'>
                    <select value='id_curso'>
                        <?php foreach ($cursos as $curso) { ?>
                            <option><?= $curso['nombre'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class='container__courses'>
                    <select value='id_curso'>
                        <option value="2024"><?= $year_now ?></option>
                        <option value="2023"><?= $year_now - 1 ?></option>
                        <option value="2022"><?= $year_now - 2 ?></option>
                        <option value="2021"><?= $year_now - 3 ?></option>
                        <option value="2020"><?= $year_now - 4 ?></option>
                    </select>

                </div>
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
                            <tr class="asistencias">
                                <td hidden>
                                    <input type="number" value="<?= $alumno['alumno_id'] ?>">
                                </td>
                                <td><?= $alumno['nombres_apellidos'] ?></td>
                                <td class="btn">
                                    <input class="asistencia presente" type='radio' name="asistencia">
                                </td>
                                <td class="btn">
                                    <input class="asistencia falta" type='radio' name="asistencia">
                                </td>
                                <td class="btn">
                                    <input class="asistencia justificado" type='radio' name="asistencia">
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tbody id="desc_justificado" hidden>
                        <tr>
                            <td colspan="4">
                                <label>Justificación:</label>
                                <input id="motivo" type="text">
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button onclick="enviarAsistencia()">
                    Enviar asistencia
                </button>
            </div>
        </div>
    </main>
    <script>
        const asistencias = document.querySelectorAll('.asistencia');
        const desc_justificado = document.querySelector('#desc_justificado');
        const motivo = document.querySelector('#motivo');

        asistencias.forEach((a) => {
            a.addEventListener('click', () => {
                if (a.classList.contains('justificado')) {
                    desc_justificado.hidden = false;
                } else {
                    desc_justificado.hidden = true;
                }
            });
        });

        const enviarAsistencia = () => {
            const asistenciasRows = document.querySelectorAll('tr.asistencias');

            asistenciasRows.forEach(function(row) {
                const alumnoId = row.querySelector('input[type="number"]').value;

                const getAsistencia = () => {
                    for (const a of asistencias) {
                        if (a.checked) {
                            if (a.classList.contains('presente')) return 'Presente';
                            if (a.classList.contains('falta')) return 'Faltó';
                            if (a.classList.contains('justificado')) return {
                                estado: 'Justificado',
                                motivo: motivo.value
                            }
                        }
                    };
                };

                console.log("ID del alumno:", alumnoId);
                console.log("Asistencia marcada:", getAsistencia());
            });
        }
    </script>
</body>

</html>