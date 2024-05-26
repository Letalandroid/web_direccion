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
            <div id="reload">
                <p>Parece que hay nuevos cambios, se sugiere <button onclick="location.reload();">recargar</button></p>
            </div>
            <div class="top">
                <div class='container__courses'>
                    <select id="id_curso">
                        <?php foreach ($cursos as $curso) { ?>
                            <option value="<?= $curso['curso_id'] ?>"><?= $curso['nombre'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class='container__courses'>
                    <select id="year">
                        <option value="2024"><?= $year_now ?></option>
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
                                <td id="nombres_apellidos"><?= $alumno['nombres_apellidos'] ?></td>
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
        const nombres_apellidos = document.querySelector('#nombres_apellidos');
        const id_curso = document.querySelector('#id_curso').value;
        const year = document.querySelector('#year').value;

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
                const asistencias = row.querySelectorAll('.asistencia');

                const getAsistencia = () => {
                    for (const a of asistencias) {
                        if (a.checked) {
                            if (a.classList.contains('presente')) return {
                                estado: 'Presente'
                            };
                            if (a.classList.contains('falta')) return {
                                estado: 'Faltó'
                            };
                            if (a.classList.contains('justificado')) return {
                                estado: 'Justificado',
                                motivo: motivo.value
                            }
                        }
                    };
                };

                const xhr = new XMLHttpRequest();
                xhr.open('POST', '/controllers/actions/docente/actionsAsistencias.php');
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        console.log(xhr.response);
                        document.querySelector('#reload').style.display = 'block';
                    } else {
                        console.log(xhr.response);
                    }
                };
                xhr.onerror = function() {
                    console.error('Error de conexión');
                };

                const data_send = `
                    createAsistencia=true&
                    alumno_id=${parseInt(alumnoId)}&
                    fecha_asistencia=${new Date().toISOString().slice(0, 10)}&
                    estado=${getAsistencia().estado}&
                    descripcion=${getAsistencia().motivo ?? ''}&
                    curso_id=${parseInt(id_curso)}
                `;

                function customReplace(match) {
                    if (match === '\n' || match === ' ') {
                        return ' ';
                    } else {
                        return match;
                    }
                }

                const replacedData = data_send.replace(/\n|\s+/g, customReplace);
                xhr.send(replacedData);
            });
        }
    </script>
</body>

</html>