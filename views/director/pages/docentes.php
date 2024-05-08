<?php

use Letalandroid\controllers\Docente;

require_once __DIR__ . '/../../../controllers/Docente.php';

session_start();
if (!isset($_SESSION['user_id']) && $_SESSION['type'] != 'Director') {
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
    <link rel="shortcut icon" href="views/director/assets/img/logo_transparent.png" type="image/x-icon" />
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
            <table border="1">
                <tr>
                    <th>DNI</th>
                    <th>Nombres y Apellidos</th>
                    <th>Género</th>
                    <th>Fecha de nacimiento</th>
                </tr>
                <?php foreach ($docentes as $docente) { ?>
                    <tr>
                        <td><?= $docente['dni'] ?></td>
                        <td><?= $docente['nombres_apellidos'] ?></td>
                        <td><?= $docente['genero'] ?></td>
                        <td><?= $docente['fecha_nacimiento'] ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </main>
</body>

</html>