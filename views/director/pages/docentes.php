<?php

use Letalandroid\controllers\Docente;

require_once __DIR__ . '/../../../controllers/Docente.php';

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] != 'Director') {
    header('Location: /');
    exit();
} 

$docentes = Docente::getAllMin();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/views/director/css/header.css" />
    <link rel="stylesheet" href="/views/director/css/docentes.css">
    <link rel="stylesheet" href="/views/director/css/datosdocente.css">
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
        <?php show_nav('Docente'); ?>
        <div class="container">
            <h1>DOCENTES</h1>
            <div class="search-container">
                <div class="input-container">
                    <label for="dni">DNI:</label>
                    <input type="text" id="dni" name="dni">
                </div>
                <div class="input-container">
                    <label for="curso_id">Curso:</label>
                    <select id="curso_id" name="curso_id">
                        <option value="">Seleccionar Curso</option>
                        <option value="">Seleccionar Curso</option>
                    </select>
                </div>
                <div class="button-container">
                    <button class="btn search" onclick="buscarDocente()">Buscar</button>
                    <button class="btn clear" onclick="clearForm()">Limpiar</button>
                </div>
            </div>
            <div class="table-container">
                <table id="docentesTable">
                    <thead>
                        <tr>
                            <th>DNI</th>
                            <th>NOMBRE Y APELLIDOS</th>
                            <th>GENERO</th>
                            <th>FECHA DE NACIMIENTO</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($docentes as $docente) : ?>
    <tr>
        <td><?= $docente['dni'] ?></td>
        <td><?= $docente['nombres_apellidos'] ?></td>
        <td><?= $docente['genero'] ?></td>
        <td><?= $docente['fecha_nacimiento'] ?></td>
        <td>
            <button class="btn_edit" onclick="window.location.href='/views/director/pages/editardocente.php?id=<?= $docente['docente_id'] ?>'"><i class="fa fa-edit"></i></button>
        </td>
        <td>
            <form action="eliminar_docente.php" method="POST">
                <input type="hidden" name="docente_id" value="<?= $docente['docente_id'] ?>">
                <button type="submit" class="btn delete" name="delete"><i class="fa fa-trash"></i></button>
            </form>
        </td>
    </tr>
<?php endforeach; ?>

                    </tbody>
                </table>    
            </div>
        </div>
    </main>
    <script>
        const docentes = <?= json_encode($docentes) ?>;

        const buscarDocente = () => {
            const dni = document.getElementById('dni').value.trim();
            const matchingDocentes = docentes.filter(docente => docente.dni.includes(dni));

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
                        <td><button class="btn edit"><i class="fa fa-edit"></i></button></td>
                        <td><button class="btn delete"><i class="fa fa-trash"></i></button></td>
                    `;
                });
            } else {
                const row = tableBody.insertRow();
                const cell = row.insertCell();
                cell.colSpan = 6;
                cell.textContent = "No se encontraron resultados";
            }
        }
//limpiar

const clearForm = () => {
            document.getElementById('dni').value = '';
            document.getElementById('curso_id').selectedIndex = 0;
            buscarDocente(); // Limpiar la tabla de docentes al limpiar los campos
        };
    </script>
</body>

</html>