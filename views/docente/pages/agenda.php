<?php


session_start();
if (!isset($_SESSION['user_id']) && $_SESSION['type'] != 'Docente') {
    header('Location: /');
    exit();
}

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
            <div class="search__agenda">
                <label>Buscar:</label>
                <div>
                    <input id="search_agenda" type="text" placeholder="Pedrito">
                    <button onclick="buscarDocente()">Buscar</button>
                    <button onclick="showAdd()">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="create__agenda">
                <h3>Agregar agenda</h3>
                <div class="container__data_agenda">
                    <div class="left">
                        <div>
                            <label>Nombres: </label>
                            <input id="nombres" class="send_data" type="text">
                        </div>
                        <div>
                            <label>DNI: </label>
                            <input id="dni" class="send_data" type="text">
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
                            <input id="apellidos" class="send_data" type="text">
                        </div>
                        <div>
                            <label>Cursos:</label>
                            <div class="cursos__container">
                                <select>
                                    <?php foreach ($cursos as $curso) { ?>
                                        <options class="cursos_docente" name="<?= $curso['nombre'] ?>" value="<?= $curso['curso_id'] ?>">  <?= $curso['nombre'] ?></options>
                                </select>
                            <?php } ?>
                            </div>
                        </div>
                        <div>
                            <label>Fecha Nacimiento: </label>
                            <input id="fecha_nacimiento" class="send_data" type="date">
                        </div>
                    </div>
                </div>
                <button onclick="addAgenda()">Agregar</button>
            </div>
            <table id="agendasTable">
                <thead>
                    <th>DNI</th>
                    <th>Nombres y Apellidos</th>
                    <th>Género</th>
                    <th>Fecha de nacimiento</th>
                </thead>
                <?php foreach ($agendas as $agenda) { ?>
                    <tr>
                        <td><?= $agenda['dni'] ?></td>
                        <td><?= $agenda['nombres_apellidos'] ?></td>
                        <td><?= $agenda['genero'] ?></td>
                        <?php $d_agenda = explode('-', date("d-m-Y", strtotime($agenda['fecha_nacimiento']))); ?>
                        <td><?= "$d_agenda[0] de $d_agenda[1] del $d_agenda[2]" ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </main>
    <script>
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
                <td>${agenda.fecha_nacimiento}</td>
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

            const apoderado = document.querySelector('#apoderado').value;
            const apoderado_dni = apoderado.split(' - ')[0];
            const nombres_apellidos = apoderado.split(' - ')[1];

            let isEmpty = false;

            document.querySelectorAll('.send_data').forEach((data) => {
                if (data.value.length <= 0 || data.value.startsWith(' ')) {
                    isEmpty = true;
                    return;
                }
            });

            if (!isEmpty) {

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
                xhr.open('POST', '/controllers/actions/actionsAgenda.php');
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
                xhr.send(`createAgenda=true&nombres=${nombres}&apellidos=${apellidos}&dni=${dni}&genero=${genero}&fecha_nacimiento=${fecha_nacimiento}&apoderado_dni=${apoderado_dni}&cursos=${cursosSeleccionados}`);
            } else {
                alert('Existen uno o más campos vacío.')
            }
        }
    </script>
</body>

</html>