<?php

use Letalandroid\controllers\Alumnos;
use Letalandroid\controllers\Apoderado;
use Letalandroid\controllers\Cursos;
use Letalandroid\controllers\Aulas;

require_once __DIR__ . '/../../../controllers/Alumnos.php';
require_once __DIR__ . '/../../../controllers/Apoderado.php';
require_once __DIR__ . '/../../../controllers/Cursos.php';
require_once __DIR__ . '/../../../controllers/Aulas.php';

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] != 'Director') {
    header('Location: /');
    exit();
}

$alumnos = Alumnos::getAllMin();
$apoderados = Apoderado::getAllFormat();
$cursos = Cursos::getAll();
$aulas = Aulas::getGrado_Seccion();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/views/director/css/header.css" />
    <link rel="stylesheet" href="/views/director/css/alumnos.css">
    <link rel="shortcut icon" href="/views/director/assets/img/logo_transparent.png" type="image/x-icon" />
    <script defer src="/views/director/js/header.js"></script>
    <script defer>
        document.addEventListener("DOMContentLoaded", () => {
            closed_menu();
        });
    </script>
    <script src="https://kit.fontawesome.com/8b1c082df7.js" crossorigin="anonymous"></script>
    <title>I.E.P Los Clavelitos de SJT - Piura | Alumnos</title>
</head>

<body>
    <?php require_once __DIR__ . '/../components/header.php' ?>
    <main>
        <?php show_nav('Alumnos'); ?>
        <div class="container__section">
            <div id="reload">
                <p>Parece que hay nuevos cambios, se sugiere <button onclick="location.reload();">recargar</button></p>
            </div>
            <div class="search__alumno">
                <label>Buscar:</label>
                <div>
                    <input id="search_alumno" type="text" placeholder="DNI" maxlength="100" >
                    <button onclick="buscarAlumno()">Buscar</button>
                    <button onclick="showAdd()">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="create__alumno">
                <h3>Agregar alumno</h3>
                <div class="container__data_alumno">
                    <div class="left">
                        <div>
                            <label>Nombres: </label>
                            <input id="nombres" class="send_data" type="text" onkeydown="return soloLetras(event)" maxlength="50" required>
                            <script src="/views/director/js/home.js"></script>
                        </div>
                        <div>
                            <label>DNI: </label>
                            <input id="dni" class="send_data" type="text" onkeydown="return soloNumeros(event)" minlength="8" maxlength="8" required>
                            <script src="/views/director/js/home.js"></script>
                        </div>
                        <div>
                            <label>Género: </label>
                            <select id="genero">
                                <option value="" disabled selected>Seleccionar género</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Femenino">Femenino</option>
                            </select>
                        </div>
                        <div>
                            <label>Apoderado</label>
                            <input  list="apoderados" id="apoderado" required>
                            <datalist id="apoderados">
                                <?php foreach ($apoderados as $apoderado) { ?>
                                    <option value="<?= $apoderado['dni'] . ' - ' . $apoderado['nombres_apellidos'] ?>">
                                    </option>
                                <?php } ?>
                            </datalist>
                        </div>
                    </div>
                    <div class="right">
                        <div>
                            <label>Apellidos: </label>
                            <input id="apellidos" class="send_data" type="text" onkeydown="return soloLetras(event)" maxlength="50" required>
                            <script src="/views/director/js/home.js"></script>
                        </div>
                        <div>
                            <label>Grado - Aula: </label>
                            <select id="aula_id">
                                <option value="" disabled selected>Seleccionar aula</option>
                                <?php foreach ($aulas as $aula) { ?>
                                    <option value="<?= $aula['aula_id'] ?>"><?= $aula['grado'].' "'.$aula['seccion'].'" '."(".$aula['nivel'].")" ?></option>
                                <?php } ?>
                            </select>
                                </div>
                        <div>
                            <label>Fecha Nacimiento: </label>
                            <input id="fecha_nacimiento" class="send_data" type="date">
                        </div>
                    </div>
                </div>
                <button onclick="addAlumno()" >Agregar</button>
            </div>
            <table id="alumnosTable">
                <thead>
                    <th>DNI</th>
                    <th>NOMBRES Y APELLIDOS</th>
                    <th>GENERO</th>
                    <th>FECHA DE NACIMIENTO</th>
                    <th>GRADO Y SECCION</th>
                    <th>NIVEL</th>
                    <th>EDITAR</th>
                    <th>ELIMINAR</th>
                </thead>
                <?php foreach ($alumnos as $alumno) { ?>
                    <tr>
                        <td><?= $alumno['dni'] ?></td>
                        <td><?= $alumno['nombres_apellidos'] ?></td>
                        <td><?= $alumno['genero'] ?></td>
                        <?php $d_alumno = explode('-', date("d-m-Y", strtotime($alumno['fecha_nacimiento']))); ?>
                        <td><?= "$d_alumno[0] de $d_alumno[1] del $d_alumno[2]" ?></td> 
                        <td><?= $alumno['grado_seccion'] ?></td>
                        <td><?= $alumno['nivel'] ?></td>
                        <td><button class="edit-button" onclick="window.location.href='/views/director/pages/editaralumnos.php?id=<?= $alumno['alumno_id'] ?>'"><i class="fa fa-edit"></button></td>                         
                        <td><button class="delete-button" onclick="eliminarAlumno(<?= $alumno['alumno_id'] ?>)"><i class="fa fa-trash"></i></button></td>                 
                    </tr>
                <?php } ?>
            </table>    
        </div>
    </main>
    <script>
        let show = false;

        const buscarApoderado = () => {
            const alumnoName = document.getElementById('search_alumno').value;
            const alumnos = <?= json_encode($alumnos) ?>;
            const matchingalumnos = alumnos.filter(alumno => alumno.nombres_apellidos.toLowerCase().includes(alumnoName));

            const tableBody = document.getElementById('alumnosTable').getElementsByTagName('tbody')[0];
            tableBody.innerHTML = "";

            if (matchingAlumnos.length > 0) {
                matchingAlumnos.forEach(alumno => {
                    const row = tableBody.insertRow();
                    row.innerHTML = `
                <td>${alumno.dni}</td>
                <td>${alumno.nombres_apellidos}</td>
                <td>${alumno.genero}</td>
                <td>${alumno.nacionalidad}</td>
                <td>${alumno.fecha_nacimiento}</td>
                <td>${alumno.aula_id}</td>
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
            const create_alumno = document.querySelector('.create__alumno');

            if (!show) {
                create_alumno.style.height = '220px';
                icon.style.transform = 'rotate(45deg)';
                show = true;
            } else {
                create_alumno.style.height = 0
                icon.style.transform = 'rotate(0)';
                show = false;
            }


        }

        const addAlumno = async () => {
    const apoderado = document.querySelector('#apoderado').value;
    const apoderado_dni = apoderado.split(' - ')[0];
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
        const aula_id = document.querySelector('#aula_id').value;

        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/controllers/actions/director/actionsAlumno.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                console.log(xhr.response);
           //     document.querySelector('#reload').style.display = 'block';
                location.reload();
            } else {
                console.log(xhr.response);
            }
        };
        xhr.onerror = function() {
            console.error('Error de conexión');
        };
        xhr.send(`createAlumno=true&nombres=${nombres}&apellidos=${apellidos}&dni=${dni}&genero=${genero}&fecha_nacimiento=${fecha_nacimiento}&apoderado_dni=${apoderado_dni}&aula_id=${aula_id}`);
    } else {
        alert('Existen uno o más campos vacío.');
    }
}


        const buscarAlumno = () => {
            const dni = document.getElementById('search_alumno').value.toLowerCase();
            const rows = document.querySelectorAll('#alumnosTable tbody tr');

            rows.forEach(row => {
                const dniValue = row.cells[0].textContent.toLowerCase();
                if (dniValue.includes(dni)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }


        // Eliminar
        const eliminarAlumno = (alumno_id) => {
    console.log(`Intentando eliminar el alumno con ID: ${alumno_id}`); 
    if (confirm('¿Estás seguro de que deseas eliminar este alumno?')) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/controllers/actions/director/actionsAlumno.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            console.log('Estado del servidor: ', xhr.status); // Registro de depuración
            console.log('Respuesta del servidor: ', xhr.response); // Registro de depuración
            if (xhr.status === 200) {
                alert('Alumno eliminado exitosamente');
                location.reload(); // Recargar la página para ver los cambios
            } else {
                alert('Error al eliminar al alumno');
                console.error(xhr.response);
            }
        };
        xhr.onerror = function() {
            alert('Error de conexión');
            console.error('Error de conexión');
        };
        xhr.send(`deleteAlumno=true&alumno_id=${alumno_id}`);
    }
}
        
    </script>
</body>

</html>