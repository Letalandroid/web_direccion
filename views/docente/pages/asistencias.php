<?php

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /');
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/views/docente/css/header.css" />
    <link rel="stylesheet" href="/views/docente/css/asistencias.css" />
    <link rel="shortcut icon" href="/views/docente/assets/img/logo_transparent.png" type="image/x-icon" />
    <script defer src="/views/docente/js/header.js"></script>
    <script defer>
        document.addEventListener("DOMContentLoaded", () => {
            closed_menu();
        });
    </script>
    <script src="https://kit.fontawesome.com/8b1c082df7.js" crossorigin="anonymous"></script>
    <title>I.E.P Los Clavelitos de SJT - Piura | Asistencias</title>
</head>

<body>
    <?php require_once __DIR__ . '/../components/header.php' ?>
    <main>
        <?php show_nav('Asistencias') ?>
        <div class="container__section">
            <div>
                <div class="section__asistencias">
                    <h2>Asistencias</h2>
                    <p>100/100</p>
                    <span>0 días de falta</span>
                </div>
            </div>
            <div class="section__table">
                <table>
                    <tr>
                        <th>Fecha</th>
                        <th>Estado</th>
                    </tr>
                    <tr>
                        <td>Hoy</td>
                        <td>
                            <span class="present">Asistió</span>
                        </td>
                    </tr>
                    <tr>
                        <td>12/04/2024</td>
                        <td>
                            <span class="present">Asistió</span>
                        </td>
                    </tr>
                    <tr>
                        <td>12/04/2024</td>
                        <td>
                            <span class="not_present">Faltó</span>
                        </td>
                    </tr>
                    <tr>
                        <td>12/04/2024</td>
                        <td>
                            <span class="present">Asistió</span>
                        </td>
                    </tr>
                    <tr>
                        <td>12/04/2024</td>
                        <td>
                            <span class="not_present">Faltó</span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </main>
</body>

</html>