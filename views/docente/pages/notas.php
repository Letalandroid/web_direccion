<?php

use Letalandroid\controllers\Cursos;
use Letalandroid\controllers\Notas;

require_once __DIR__ . '/../../../controllers/Cursos.php';
require_once __DIR__ . '/../../../controllers/Notas.php';

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] != 'Docente') {
    header('Location: /');
    exit();
}

$cursos = Cursos::getForIdDoc($_SESSION['docente_id']);
$alumnos = [];

foreach ($cursos as $curso) {
    $alumnos += Notas::getAll_Course($curso['curso_id']);
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
        <?php require_once __DIR__ . '/../components/loader.php' ?>
        <div class="container__section">
            <div id="reload">
                <p>Parece que hay nuevos cambios, se sugiere <button onclick="location.reload();">recargar</button></p>
            </div>
            <div class="header">
                <h2>NOTAS</h2>
                <div class="form-row">
                    <div class="form-group">
                        <label>Curso:</label>
                        <select onchange="cargarAlumnos()" id="curso" name="curso">
                            <?php foreach ($cursos as $curso) { ?>
                                <option value="<?= $curso['curso_id'] ?>"><?= $curso['nombre'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Unidad:</label>
                        <select onchange="cargarAlumnos()" id="unidad" name="unidad">
                            <option value="1">Primer bimestre</option>
                            <option value="2">Segundo bimestre</option>
                            <option value="3">Tercer bimestre</option>
                            <option value="4">Cuarto bimestre</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Año:</label>
                        <select onchange="cargarAlumnos()" id="year" name="año">
                            <option value="2024">2024</option>
                            <option value="2023">2023</option>
                            <option value="2022">2022</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Alumno:</label>
                        <select onchange="cargarAlumnos()" id="alumno" name="alumno"></select>
                    </div>
                    <button id="buscar">Buscar</button>
                    <button onclick="enviarNota()" id="guardar"><i class="fas fa-download"></i> Guardar</button>
                </div>
            </div>
            <style>
                .notas-table {
                    border: 1px solid #ccc;
                    border-collapse: collapse;
                    border-radius: 10px;
                    overflow: hidden;
                }

                .notas-table thead th,
                .notas-table tbody td {
                    border-radius: 10px;
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
                        <td><input id="n_pc" type="number" class="nota-input"></td>
                        <td><button onclick="limpiar('n_pc')" class="delete-btn"><i class="fas fa-trash"></i></button></td>
                    </tr>
                    <tr>
                        <td>Participacion</td>
                        <td><input id="n_participacion" type="number" class="nota-input"></td>
                        <td><button onclick="limpiar('n_participacion')" class="delete-btn"><i class="fas fa-trash"></i></button></td>
                    </tr>
                    <tr>
                        <td>Examen</td>
                        <td><input id="n_examen" type="number" class="nota-input"></td>
                        <td><button onclick="limpiar('n_examen')" class="delete-btn"><i class="fas fa-trash"></i></button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
    <script>
        const alumnos = <?= json_encode($alumnos); ?>;
        const curso_id = document.querySelector('#curso');
        const unidad = document.querySelector('#unidad');
        const year = document.querySelector('#year');
        const alumno = document.querySelector('#alumno');
        const n_pc = document.querySelector('#n_pc');
        const n_participacion = document.querySelector('#n_participacion');
        const n_examen = document.querySelector('#n_examen');

        const limpiar = (note) => {
            document.querySelector(`#${note}`).value = 0;
        }

        function cargarAlumnos() {
            const cursoSeleccionado = document.getElementById('curso').value;
            const listaAlumnos = document.getElementById('alumno');

            listaAlumnos.innerHTML = '';

            const alumnosFiltrados = alumnos.filter(alumno => alumno.curso_id == cursoSeleccionado);
            loader.style.display = 'flex';

            alumnosFiltrados.forEach(alumno => {
                const optionAlumno = document.createElement('option');
                optionAlumno.value = alumno.alumno_id;
                optionAlumno.textContent = alumno.nombres_apellidos;
                listaAlumnos.appendChild(optionAlumno);
                switch (alumno.tipo) {
                    case 'Practica':
                        n_pc.value = alumno.valor;
                    case 'Participacion':
                        n_participacion.value = alumno.valor;
                    case 'Examen':
                        n_examen.value = alumno.valor;
                    default:
                        break;
                }
            });

            loader.style.display = 'none';
        }

        cargarAlumnos();

        const enviarNota = () => {

            const notas = [{
                    tipo: 'Practica',
                    valor: n_pc.value
                },
                {
                    tipo: 'Participacion',
                    valor: n_participacion.value
                },
                {
                    tipo: 'Examen',
                    valor: n_examen.value
                },
            ]


            let success = 0;
            let error = 0;
            loader.style.display = 'flex';

            notas.forEach((nota) => {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', '/controllers/actions/docente/actionsNotas.php');
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        console.log(xhr.response);
                        success += 1;
                    } else {
                        console.log(xhr.response);
                        error += 1;
                    }

                    loader.style.display = 'none';
                    document.querySelector('#reload').innerHTML = `
				<b>(${success})</b> Notas, <b>(${error})</b> Errores
			`;
                    document.querySelector('#reload').style.display = 'block';
                };
                xhr.onerror = function() {
                    console.error('Error de conexión');
                };
                const data_send = `
                createNota=true&
                curso_id=${curso_id.value}&
                unidad=${unidad.value}&
                year=${year.value}&
                alumno_id=${alumno.value}&
                tipo=${nota.tipo}&
                valor=${nota.valor}
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
            })

        }
    </script>
</body>

</html>