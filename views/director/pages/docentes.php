<?php

use Letalandroid\controllers\Docente;
use Letalandroid\controllers\Cursos;

require_once __DIR__ . '/../../../controllers/Docente.php';
require_once __DIR__ . '/../../../controllers/Cursos.php';

session_start();
if (!isset($_SESSION['user_id']) && $_SESSION['type'] != 'Director') {
    header('Location: /');
    exit();
}

$docentes = Docente::getAllMin();
$cursos = Cursos::getAll();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/views/director/css/header.css" />
    <link rel="stylesheet" href="/views/director/css/docentes.css">
    <link rel="shortcut icon" href="/views/director/assets/img/logo_transparent.png" type="image/x-icon" />
    <script defer src="/views/director/js/header.js"></script>
    <script defer>
        document.addEventListener("DOMContentLoaded", () => {
            closed_menu();
        });
    </script>
    <script src="https://kit.fontawesome.com/8b1c082df7.js" crossorigin="anonymous"></script>
    <title>I.E.P Los Clavelitos de SJT - Piura | Docentes</title>
</head>

<body>
    <?php require_once __DIR__ . '/../components/header.php' ?>
    <main>
        <?php show_nav('Docentes'); ?>
        <div class="container__section">
            <div id="reload">
                <p>Parece que hay nuevos cambios, se sugiere <button onclick="location.reload();">recargar</button></p>
            </div>
            <div class="search__docente">
                <label>Buscar: </label>
                <div>
                    <input id="search_docente" type="text" placeholder="<?= $docentes[0]['nombres_apellidos'] ?>">
                    <button onclick="buscarDocente()">Buscar</button>
                    <button onclick="showAdd()">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="create__docente">
                <h3>Agregar docente</h3>
                <div class="container__data_docente">
                    <div class="left">
                        <div>
                            <label>Nombres: </label>
                            <input id="nombres" type="text">
                        </div>
                        <div>
                            <label>DNI: </label>
                            <input id="dni" type="text">
                        </div>
                        <div>
                            <label>Género: </label>
                            <select id="genero">
                                <option value="Masculino">Masculino</option>
                                <option value="Femenino">Femenino</option>
                                <option value="Prefiero no decirlo">Prefiero no decirlo</option>
                            </select>
                        </div>
                    </div>
                    <div class="right">
                        <div>
                            <label>Apellidos: </label>
                            <input id="apellidos" type="text">
                        </div>
                        <div>
                            <label>Curso: </label>
                            <div class="cursos__container">
                                <?php foreach ($cursos as $curso) { ?>
                                    <div>
                                        <input class="cursos_docente" name="<?= $curso['nombre'] ?>" value="<?= $curso['curso_id'] ?>" type="checkbox">
                                        <label><?= $curso['nombre'] ?></label>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div>
                            <label>Fecha Nacimiento: </label>
                            <input id="fecha_nacimiento" type="date">
                        </div>
                    </div>
                </div>
                <button onclick="addDocente()">Agregar</button>
            </div>
            <table id="docentesTable">
                <thead>
                    <th>DNI</th>
                    <th>Nombres y Apellidos</th>
                    <th>Género</th>
                    <th>Fecha de nacimiento</th>
                </thead>
                <?php foreach ($docentes as $docente) { ?>
                    <tr>
                        <td><?= $docente['dni'] ?></td>
                        <td><?= $docente['nombres_apellidos'] ?></td>
                        <td><?= $docente['genero'] ?></td>
                        <?php $d_docente = explode('-', date("d-m-Y", strtotime($docente['fecha_nacimiento']))); ?>
                        <td><?= "$d_docente[0] de $d_docente[1] del $d_docente[2]" ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </main>
    <script>
        let show = false;

        const buscarDocente = () => {
            const docenteName = document.getElementById('search_docente').value;
            const docentes = <?= json_encode($docentes) ?>;
            const matchingDocentes = docentes.filter(docente => docente.nombres_apellidos.toLowerCase().includes(docenteName));

            const tableBody = document.getElementById('docentesTable').getElementsByTagName('tbody')[0];
            tableBody.innerHTML = "";

            if (matchingDocentes.length > 0) {
                matchingDocentes.forEach(docente => {
                    const row = tableBody.insertRow();
                    row.innerHTML = `
                <td>${docente.dni}</td>
                <td>${docente.nombres_apellidos}</td>
                <td>${docente.genero}</td>
                <td>${docente.fecha_nacimiento}</td>
            `;
                });
            } else {
                const row = tableBody.insertRow();
                const cell = row.insertCell();
                cell.colSpan = 4;
                cell.textContent = "No se encontraron resultados";
            }
        }

        const showAdd = () => {

            const icon = document.querySelector('.fa-plus');
            const create_docente = document.querySelector('.create__docente');

            if (!show) {
                create_docente.style.height = '211px';
                icon.style.transform = 'rotate(45deg)';
                show = true;
            } else {
                create_docente.style.height = 0
                icon.style.transform = 'rotate(0)';
                show = false;
            }


        }

        const addDocente = async () => {

            const nombres = document.querySelector('#nombres').value;
            const apellidos = document.querySelector('#apellidos').value;
            const dni = document.querySelector('#dni').value;
            const genero = document.querySelector('#genero').value;
            const fecha_nacimiento = document.querySelector('#fecha_nacimiento').value;

            const cursosSeleccionados = [];
            document.querySelectorAll('.cursos_docente').forEach((curso) => {
                if (curso.checked) {
                    cursosSeleccionados.push(curso.value);
                }
            });

            const xhr = new XMLHttpRequest();
            xhr.open('POST', '/controllers/actionsDocente/add.php');
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
            xhr.send(`createDocente=true&nombres=${nombres}&apellidos=${apellidos}&dni=${dni}&genero=${genero}&fecha_nacimiento=${fecha_nacimiento}&cursos=${cursosSeleccionados}`);
        }
    </script>
</body>

</html>