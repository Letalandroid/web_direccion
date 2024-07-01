<?php

use Letalandroid\controllers\Docente;
use Letalandroid\controllers\Cursos;

require_once __DIR__ . '/../../../controllers/Docente.php';
require_once __DIR__ . '/../../../controllers/Cursos.php';

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] != 'Director') {
    header('Location: /');
    exit();
}

$docentes = Docente::getAll();
$cursos = Cursos::getAll();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/views/director/css/header.css" />
    <link rel="stylesheet" href="/views/director/css/contrataciones.css">
    <link rel="shortcut icon" href="/views/director/assets/img/logo_transparent.png" type="image/x-icon" />
    <script defer src="/views/director/js/header.js"></script>
    <script defer>
        document.addEventListener("DOMContentLoaded", () => {
            closed_menu();
        });
    </script>
    <script src="https://kit.fontawesome.com/8b1c082df7.js" crossorigin="anonymous"></script>
    <title>I.E.P Los Clavelitos de SJT - Piura | Contrataciones</title>
</head>

<body>
    <?php require_once __DIR__ . '/../components/header.php' ?>
    <main>
        <?php show_nav('Docente'); ?>

        <div class="container__principal">
            <h1>DOCENTE</h1>
            <form class="form" id="docenteForm">
                <div class="row">
                    <div class="column">
                        <label for="dni">DNI:</label>
                        <input type="text" id="dni" name="dni" onkeydown="return soloNumeros(event)" minlength="8" maxlength="8" required>
                        <script src="/views/director/js/home.js"></script>
                    </div>
                    <div class="column">
                        <label for="fecha_nacimiento">FECHA DE NACIMIENTO:</label>
                        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required>
                    </div>
                </div>
                <div class="row">
                    <div class="column">
                        <label for="nombres">NOMBRES:</label>
                        <input type="text" id="nombres" name="nombres" onkeydown="return soloLetras(event)" maxlength="50" required>
                        <script src="/views/director/js/home.js"></script>
                    </div>
                    <div class="column">
                        <label for="cursos">CURSOS:</label>
                        <select id="curso_id" name="curso_id" required>
                            <option value="" disabled selected>Seleccionar cursos</option>
                            <?php foreach ($cursos as $curso): ?>
                                <option value="<?= htmlspecialchars($curso['curso_id'] ?? '') ?>"><?= htmlspecialchars($curso['nombre'] ?? '') ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="column">
                        <label for="apellidos">APELLIDOS:</label>
                        <input type="text" id="apellidos" name="apellidos" onkeydown="return soloLetras(event)" maxlength="50" required>
                        <script src="/views/director/js/home.js"></script>
                    </div>
                    <div class="column">
                        <label for="genero" required>GENERO:</label>
                        <select id="genero" name="genero">
                            <option value="" disabled selected>Seleccionar género</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="column">
                        <label for="rol">ROL:</label>
                        <select id="rol" name="rol">
                            <option value="" disabled selected>Seleccionar rol</option>
                            <option value="Administrador">Administrador</option>
                            <option value="Docente">Docente</option>
                        </select>
                    </div>
                </div>
                
                <div class="row">
                    <div class="button-container">
                        <div class="buttons-right">
                        <button onclick="window.open('/views/pdf/pages/director/imprimirDocentes.php', '_blank')"  class="pdf"><i class="fas fa-file-pdf"></i> Generar PDF</button>
                            <button type="reset" class="limpiar">LIMPIAR</button>
                            <button type="button" class="agregar" id="addButton"><i class="fas fa-plus-square"></i> Añadir</button>
                        </div>
                    </div>
                </div>
            </form>

            <table>
                <thead>
                    <tr>
                        <th>DNI</th>
                        <th>Nombre y Apellidos</th>
                        <th>Ver</th>
                        <th>Rol</th>
                        <th>Fecha de Nacimiento</th>
                        <th>Cursos</th>
                        <th>Género</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody id="docenteTableBody">
                    <?php foreach ($docentes as $docente): ?>
                    <tr data-docente-id="<?= htmlspecialchars($docente['id'] ?? '') ?>">
                        <td><?= htmlspecialchars($docente['dni'] ?? '') ?></td>
                        <td><?= htmlspecialchars(($docente['nombres'] ?? '') . ' ' . ($docente['apellidos'] ?? '')) ?></td>
                        <td><button class="ver"><i class="fas fa-eye"></i></button></td>
                        <td><?= htmlspecialchars($docente['rol'] ?? '') ?></td>
                        <td><?= htmlspecialchars($docente['fecha_nacimiento'] ?? '') ?></td>
                        <td><?= htmlspecialchars($docente['curso_nombre'] ?? '') ?></td>
                        <td><?= htmlspecialchars($docente['genero'] ?? '') ?></td>
                        <td><button class="editar" onclick="editDocente(<?= htmlspecialchars($docente['id'] ?? '') ?>)"><i class="fa fa-edit"></i></button></td>
                        <td><button class="eliminar" onclick="deleteDocente(<?= htmlspecialchars($docente['id'] ?? '') ?>)"><i class="fa fa-trash"></i></button></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <script>
        document.getElementById('addButton').addEventListener('click', addDocente);

async function addDocente() {
    const dni = document.getElementById('dni').value;
    const nombres = document.getElementById('nombres').value;
    const apellidos = document.getElementById('apellidos').value;
    const rol = document.getElementById('rol').value;
    const fecha_nacimiento = document.getElementById('fecha_nacimiento').value;
    const curso_id = document.getElementById('curso_id').value;
    const genero = document.getElementById('genero').value;

    if (dni == '' || nombres == '' || apellidos == '') {
        alert('Por favor, complete todos los campos.');
        return;
    }

    try {
        const response = await fetch('/controllers/actions/director/actionsDocente.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                createDocente: 'true',
                dni,
                nombres,
                apellidos,
                rol,
                fecha_nacimiento,
                curso_id,
                genero
            })
        });

        const result = await response.json();
        if (result.success) {
            alert('Docente añadido exitosamente');
            location.reload();
        } else {
            alert('Error al añadir docente: ' + result.message);
        }
    } catch (error) {
        console.error('Error de conexión', error);
        alert('Error de conexión');
    }
}


        async function editDocente(docenteId) {
            try {
                const response = await fetch('/controllers/actions/director/actionsDocente.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        action: 'getById',
                        docente_id: docenteId
                    })
                });

                const result = await response.json();
                if (result.success) {
                    const docente = result.data;
                    document.getElementById('dni').value = docente.dni ?? '';
                    document.getElementById('nombres').value = docente.nombres ?? '';
                    document.getElementById('apellidos').value = docente.apellidos ?? '';
                    document.getElementById('rol').value = docente.rol ?? '';
                    document.getElementById('fecha_nacimiento').value = docente.fecha_nacimiento ?? '';
                    document.getElementById('curso_id').value = docente.curso_id ?? '';
                    document.getElementById('genero').value = docente.genero ?? '';
                    document.getElementById('addButton').textContent = 'Actualizar';
                    document.getElementById('addButton').onclick = () => updateDocente(docenteId);
                } else {
                    alert('Error al obtener datos del docente: ' + result.message);
                }
            } catch (error) {
                console.error('Error de conexión', error);
                alert('Error de conexión');
            }
        }

        async function updateDocente(docenteId) {
            const dni = document.getElementById('dni').value.trim();
            const nombres = document.getElementById('nombres').value.trim();
            const apellidos = document.getElementById('apellidos').value.trim();
            const rol = document.getElementById('rol').value;
            const fecha_nacimiento = document.getElementById('fecha_nacimiento').value;
            const curso_id = document.getElementById('curso_id').value;
            const genero = document.getElementById('genero').value;

            if (!dni || !nombres || !apellidos || !rol || !fecha_nacimiento || !curso_id || !genero) {
                alert('Por favor, complete todos los campos.');
                return;
            }

            try {
                const response = await fetch('/controllers/actions/docente/actionsDocente.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        action: 'update',
                        docente_id: docenteId,
                        dni,
                        nombres,
                        apellidos,
                        rol,
                        fecha_nacimiento,
                        curso_id,
                        genero
                    })
                });

                const result = await response.json();
                if (result.success) {
                    alert('Docente actualizado exitosamente');
                    location.reload();
                } else {
                    alert('Error al actualizar docente: ' + result.message);
                }
            } catch (error) {
                console.error('Error de conexión', error);
                alert('Error de conexión');
            }
        }

        function deleteDocente(docenteId) {
            if (confirm('¿Estás seguro de que deseas eliminar este docente?')) {
                fetch('/controllers/actions/docente/actionsDocente.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        action: 'delete',
                        docente_id: docenteId
                    })
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        alert('Docente eliminado exitosamente');
                        location.reload();
                    } else {
                        alert('Error al eliminar al docente: ' + result.message);
                    }
                })
                .catch(error => {
                    console.error('Error de conexión', error);
                    alert('Error de conexión');
                });
            }
        }
    </script>
</body>

</html>
