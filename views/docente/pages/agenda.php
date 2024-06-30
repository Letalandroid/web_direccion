<?php

use Letalandroid\controllers\Cursos;
use Letalandroid\controllers\Agenda;

require_once __DIR__ . '/../../../controllers/Cursos.php';
require_once __DIR__ . '/../../../controllers/Agenda.php';


session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] != 'Docente') {
    header('Location: /');
    exit();
}

$cursos = Cursos::getForIdDoc($_SESSION['docente_id']);
$agendas = Agenda::getAllCurso();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/views/docente/css/header.css" />
    <link rel="stylesheet" href="/views/docente/css/agenda.css">
    <link rel="shortcut icon" href="/views/docente/assets/img/logo_transparent.png" type="image/x-icon" />
    <script defer src="/views/docente/js/header.js"></script>
    <script defer>
        document.addEventListener("DOMContentLoaded", () => {
            closed_menu();
        });
    </script>
    <script src="https://kit.fontawesome.com/8b1c082df7.js" crossorigin="anonymous"></script>
    <title>I.E.P Los Clavelitos de SJT - Piura | Activiades</title>
</head>

<body>
    <?php require_once __DIR__ . '/../components/header.php' ?>
    <main>
        <?php show_nav('Agenda'); ?>
        <div class="container__section">
            <div id="reload">
                <p>Parece que hay nuevos cambios, se sugiere <button onclick="location.reload();">recargar</button></p>
            </div>
            <div class="create__agenda">
                <h3>AGREGAR AGENDA</h3>
                <div class="container__data_agenda">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Fecha:</label>
                            <input id="fecha_actividad" class="send_data" type="date">
                        </div>
                        <div class="form-group">
                            <label>Secciones:</label>
                            <select id="curso">
                                <option value="">Seleccionar Curso</option>
                                <?php foreach ($cursos as $curso) { ?>
                                    <option class="cursos_docente" value="<?= $curso['curso_id'] ?>">
                                        <?= $curso['nombre'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Descripción:</label>
                            <textarea id="descripcion" class="send_data" type="text"></textarea>
                        </div>
                    </div>
                    <div class="form-row" id="button-container">
                        <button id="add-button" onclick="addAgenda()"><i class="fas fa-plus-square"></i>  Añadir</button>
                        <button id="clear-button" onclick="clearForm()"><i class="fas fa-trash-alt"></i>  Limpiar</button>
                    </div>
                </div>
            </div>

            <div class="table-container">
                <table id="agendasTable">
                    <thead>
                        <th>Curso</th>
                        <th>Descripcion</th>
                        <th>Fecha</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </thead>
                    <?php foreach ($agendas as $agenda) { ?>
                        <tr>
                        <td>
                            <?= htmlspecialchars($agenda['curso']) ?></td>
                            <td><?= htmlspecialchars($agenda['descripcion']) ?></td>
                            <?php $d_agenda = explode('-', date("d-m-Y", strtotime($agenda['fecha_evento']))); ?>
                            <td><?= htmlspecialchars("$d_agenda[0] de $d_agenda[1] del $d_agenda[2]") ?></td>
                            <td><button class="edit-button" onclick="window.location.href='/views/docente/pages/ageEditar.php?id=<?= $agenda['evento_id'] ?>'"><i class="fa fa-edit"></button></td>
                            <td><button class="delete-button" onclick="eliminarAgenda(<?= $agenda['evento_id'] ?>)"><i class="fa fa-trash"></i></button></td>
                            
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </main>
    <script>

        //Para Agregar datos a la tabla
        let show = false;

        const buscarApoderado = () => {
            const agendaName = document.getElementById('search_agenda').value;
            const agendas = <?= json_encode($agendas) ?>;
            const matchingagendas = agendas.filter(agenda => agenda.nombres_apellidos.toLowerCase().includes(agendaName));

            const tableBody = document.getElementById('agendasTable').getElementsByTagName('tbody')[0];
            tableBody.innerHTML = "";

            if (matchingAgendas.length > 0) {
                matchingAgendas.forEach(agenda => {
                    const row = tableBody.insertRow();
                    row.innerHTML = `
                <td>${agenda.dni}</td>
                <td>${agenda.nombres_apellidos}</td>
                <td>${agenda.genero}</td>
                <td>${agenda.nacionalidad}</td>
                <td>${agenda.fecha_actividad}</td>
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
            const create_agenda = document.querySelector('.create__agenda');

            if (!show) {
                create_agenda.style.height = '220px';
                icon.style.transform = 'rotate(45deg)';
                show = true;
            } else {
                create_agenda.style.height = 0
                icon.style.transform = 'rotate(0)';
                show = false;
            }


        }


        const addAgenda = async () => {
    let isEmpty = false;
    document.querySelector('#reload').style.display = 'none';

    document.querySelectorAll('.send_data').forEach((data) => {
        if (data.value.length <= 0 || data.value.startsWith(' ')) {
            isEmpty = true;
            return;
        }
    });

    if (!isEmpty) {
        const descripcion = document.querySelector('#descripcion').value;
        const curso = document.querySelector('#curso').value;
        const fecha_actividad = document.querySelector('#fecha_actividad').value;

        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/../../../controllers/actions/docente/actionsAgenda.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                console.log(xhr.response);
                document.querySelector('#reload').style.display = 'block';
                location.reload(); // Recargar la página para ver los cambios
            } else {
                console.log(xhr.response);
            }
        };
        xhr.onerror = function() {
            console.error('Error de conexión');
        };
        xhr.send(`createAgenda=true&descripcion=${descripcion}&curso_id=${curso}&fecha_actividad=${fecha_actividad}`);
    } else {
        alert('Existen uno o más campos vacío.');
    }
}

        // Para Limpiar Fecha, Curso y descripcion
        const clearForm = () => {
        document.getElementById('fecha_actividad').value = '';
        document.getElementById('curso').selectedIndex = 0;
        document.getElementById('descripcion').value = '';
        };


        // Eliminar
        const eliminarAgenda = (evento_id) => {
    console.log(`Intentando eliminar el evento con ID: ${evento_id}`); 
    if (confirm('¿Estás seguro de que deseas eliminar esta actividad?')) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/controllers/actions/docente/actionsAgenda.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            console.log('Estado del servidor: ', xhr.status); // Registro de depuración
            console.log('Respuesta del servidor: ', xhr.response); // Registro de depuración
            if (xhr.status === 200) {
                alert('Actividad eliminada exitosamente');
                location.reload(); // Recargar la página para ver los cambios
            } else {
                alert('Error al eliminar la actividad');
                console.error(xhr.response);
            }
        };
        xhr.onerror = function() {
            alert('Error de conexión');
            console.error('Error de conexión');
        };
        xhr.send(`deleteAgenda=true&evento_id=${evento_id}`);
    }
}



        

    </script>
</body>

</html>