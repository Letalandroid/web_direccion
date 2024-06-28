<?php

use Letalandroid\controllers\Apoderado;

require_once __DIR__ . '/../../../controllers/Apoderado.php';

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] != 'Director') {
    header('Location: /');
    exit();
}

$apoderados_con = Apoderado::getAllCon();
$apoderados_reverse = Apoderado::getAllReverse();
$apoderados_sin = Apoderado::getAllSinAlumn();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/views/director/css/header.css" />
    <link rel="stylesheet" href="/views/director/css/apoderado.css">
    <link rel="shortcut icon" href="/views/director/assets/img/logo_transparent.png" type="image/x-icon" />
    <script defer src="/views/director/js/header.js"></script>
    <script defer>
        document.addEventListener("DOMContentLoaded", () => {
            closed_menu();
        });
    </script>
    <script src="https://kit.fontawesome.com/8b1c082df7.js" crossorigin="anonymous"></script>
    <title>I.E.P Los Clavelitos de SJT - Piura | Apoderados</title>
</head>

<body>
    <?php require_once __DIR__ . '/../components/header.php' ?>
    <main>
        <?php show_nav('Apoderados'); ?>
        <div class="container__section">
            <div id="reload">
                <p>Parece que hay nuevos cambios, se sugiere <button onclick="location.reload();">recargar</button></p>
            </div>
            <div class="search__apoderado">
                <label>Buscar:</label>
                <div>
                    <input id="search_apoderado" type="text" placeholder="<?= $apoderados_reverse[0]['nombres_apellidos'] ?>">
                    <button onclick="buscarApoderado()">Buscar</button>
                    <button onclick="showAdd()">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="create__apoderado">
                <h3>Agregar apoderado</h3>
                <div class="container__data_apoderado">
                    <div class="left">
                        <div>
                            <label>Nombres: </label>
                            <input id="nombres" class="send_data" type="text" onkeydown="return soloLetras(event)" maxlength="50" required>
                            <script src="/views/director/js/home.js"></script>
                        </div>
                        <div>
                            <label>DNI: </label>
                            <input id="dni" class="send_data" type="text" onkeydown="return soloNumeros(event)" maxlength="8" required>
                            <script src="/views/director/js/home.js"></script>
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
                            <input id="apellidos" class="send_data" type="text" onkeydown="return soloLetras(event)" maxlength="50" required>
                            <script src="/views/director/js/home.js"></script>
                        </div>
                        <div>
                            <label>Nacionalidad:</label>
                            <input id="nacionalidad" class="send_data" type="text" onkeydown="return soloLetras(event)" maxlength="20" required>
                        </div>
                        <div>
                            <label>Fecha Nacimiento: </label>
                            <input id="fecha_nacimiento" class="send_data" type="date" required>
                        </div>
                    </div>
                </div>
                <div class="botones">
                <button onclick="addApoderado()">Agregar</button>
                <button onclick="limpiarBusqueda()" class="btn btn-orange">Limpiar</button>
                </div>
            </div>
            <?php if (!empty($apoderados_sin)) { ?>
                <div class="apo_null_container">
                    <h2>Apoderados sin hijos asignados</h2>
                    <table>
                        <thead>
                            <th>DNI</th>
                            <th>NOMBRES</th>
                            <th>APELLIDOS</th>
                            <th>GENERO</th>
                            <th>NACIONALIDAD</th>
                            <th>FECHA DE NACIMIENTO</th>
                            <th>ALUMNOS</th>
                            <th>EDITAR</th>
                            <th>ELIMINAR</th>
                        </thead>
                        <tbody>
                            <?php foreach ($apoderados_sin as $apoderado) { ?>
                                <tr>
                                    <td><?= $apoderado['dni'] ?></td>
                                    <td><?= $apoderado['nombres_apellidos'] ?></td>
                                    <td><?= $apoderado['genero'] ?></td>
                                    <td><?= $apoderado['nacionalidad'] ?></td>
                                    <?php $d_apoderado = explode('-', date("d-m-Y", strtotime($apoderado['fecha_nacimiento']))); ?>
                                    <td><?= "$d_apoderado[0] de $d_apoderado[1] del $d_apoderado[2]" ?></td>
                                    <td><button class="edit-button" onclick="window.location.href='/views/director/pages/editaralumnos.php?id=<?= $apoderado_id['apoderado_id'] ?>'"><i class="fa fa-edit"></button></td>                         
                                     <td><a href="/views/director/pages/alumnos.php?id=<?php echo $apoderado_id['apoderado_id'] ?>" class="btn btn-danger">X</a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
            <table id="apoderadosTable">
                <thead>
                            <th>DNI</th>
                            <th>NOMBRES</th>
                            <th>APELLIDOS</th>
                            <th>GENERO</th>
                            <th>NACIONALIDAD</th>
                            <th>FECHA DE NACIMIENTO</th>
                            <th>ALUMNOS</th>
                            <th>EDITAR</th>
                            <th>ELIMINAR</th>
                </thead>
                <tbody>
                    <?php foreach ($apoderados_con as $apoderado) { ?>
                        <tr>
                            <td><?= $apoderado['dni'] ?></td>
                            <td><?= $apoderado['nombres'] ?></td>
                            <td><?= $apoderado['apellidos'] ?></td>
                            <td><?= $apoderado['genero'] ?></td>
                            <td><?= $apoderado['nacionalidad'] ?></td>
                            <?php $d_apoderado = explode('-', date("d-m-Y", strtotime($apoderado['fecha_nacimiento']))); ?>
                            <td><?= "$d_apoderado[0] de $d_apoderado[1] del $d_apoderado[2]" ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>
    <script>
        let show = false;

        const buscarApoderado = () => {
            const apoderadoName = document.getElementById('search_apoderado').value.toLowerCase();
            const apoderados = <?= json_encode($apoderados_con ?? []) ?>;
            const matchingApoderados = apoderados.filter(apoderado => 
            apoderado.nombres_apellidos.toLowerCase().includes(apoderadoName.toLowerCase()) || 
            apoderado.dni.includes(apoderadoName)
            );

            const tableBody = document.getElementById('apoderadosTable').getElementsByTagName('tbody')[0];
            tableBody.innerHTML = "";

            if (matchingApoderados.length > 0) {
                matchingApoderados.forEach(apoderado => {
                    const row = tableBody.insertRow();
                    row.innerHTML = `
                        <td>${apoderado.dni}</td>
                        <td>${apoderado.nombres_apellidos}</td>
                        <td>${apoderado.genero}</td>
                        <td>${apoderado.nacionalidad}</td>
                        <td>${apoderado.fecha_nacimiento}</td>
                    `;
                });
            } else {
                const row = tableBody.insertRow();
                const cell = row.insertCell();
                cell.colSpan = 5;
                cell.textContent = "No se encontraron resultados";
            }
        }

        const showAdd = () => {
            const icon = document.querySelector('.fa-plus');
            const create_apoderado = document.querySelector('.create__apoderado');

            if (!show) {
                create_apoderado.style.height = 'auto';
                icon.style.transform = 'rotate(45deg)';
                show = true;
            } else {
                create_apoderado.style.height = 0
                icon.style.transform = 'rotate(0)';
                show = false;
            }
        }

        const addApoderado = async () => {
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
                const nacionalidad = document.querySelector('#nacionalidad').value;
                const fecha_nacimiento = document.querySelector('#fecha_nacimiento').value;

                const xhr = new XMLHttpRequest();
                xhr.open('POST', '/controllers/actions/director/actionsApoderado.php');
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
                xhr.send(`createApoderado=true&nombres=${nombres}&apellidos=${apellidos}&dni=${dni}&genero=${genero}&fecha_nacimiento=${fecha_nacimiento}&nacionalidad=${nacionalidad}`);
            } else {
                alert('Existen uno o más campos vacíos.');
            }
        }
        const limpiarBusqueda = () => {
            document.getElementById('search_apoderado').value = '';
            const rows = document.querySelectorAll('#apoderadosTable tbody tr');
            rows.forEach(row => {
                row.style.display = '';
            });
        }
    </script>
</body>

</html>
