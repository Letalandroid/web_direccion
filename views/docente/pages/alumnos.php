<?php






session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] != 'Docente') {
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
    <link rel="stylesheet" href="/views/docente/css/alumnos.css">
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
        <?php show_nav('Alumnos') ?>
        <div class="container">
            <h1>ESTUDIANTES DESIGNADOS</h1>
            <input type="text" id="search" placeholder="Buscar..." onkeyup="searchTable()">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>DNI</th>
                        <th>NOMBRES</th>
                        <th>APELLIDOS</th>
                        <th>GENERO</th>
                        <th>FECHA DE NACIMIENTO</th>
                        <th>GRADO</th>
                        <th>SECCION</th>
                        <th>NIVEL</th>
                        <th>APODERADO</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        <main>
        <script>
            function searchTable() {
                var input, filter, table, tr, td, i, j, txtValue;
                input = document.getElementById("search");
                filter = input.value.toUpperCase();
                table = document.querySelector("table");
                tr = table.getElementsByTagName("tr");

                for (i = 1; i < tr.length; i++) {
                    tr[i].style.display = "none";
                    td = tr[i].getElementsByTagName("td");
                    for (j = 0; j < td.length; j++) {
                        if (td[j]) {
                            txtValue = td[j].textContent || td[j].innerText;
                            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                tr[i].style.display = "";
                                break;
                            }
                        }
                    }
                }
            }
        </script>

        
</body>

</html>