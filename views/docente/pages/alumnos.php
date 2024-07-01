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
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] != 'Docente') {
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
    <link rel="stylesheet" href="/views/docente/css/header.css" />
    <link rel="stylesheet" href="/views/docente/css/alumnos.css">
    <link rel="shortcut icon" href="/views/docente/assets/img/logo_transparent.png" type="image/x-icon" />
    <script defer src="/views/docente/js/header.js"></script>
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
            <div class="search__alumno">
                <label>Buscar:</label>
                <div>
                    <input id="search_alumno" type="text" placeholder="DNI" maxlength="100" >
                    <button onclick="buscarAlumno()">Buscar</button>
                    </button>
                </div>
            </div>
            <table id="alumnosTable">
                <thead>
                    <th>DNI</th>
                    <th>NOMBRES Y APELLIDOS</th>
                    <th>GENERO</th>
                    <th>FECHA DE NACIMIENTO</th>
                    <th>GRADO Y SECCION</th>
                    <th>NIVEL</th>
                    
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
                        
                    </tr>
                <?php } ?>
            </table>    
        </div>
    </main>
    <script>
        let show = false;

        
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
    </script>
</body>

</html>