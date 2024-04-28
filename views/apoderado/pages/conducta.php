<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/views/apoderado/css/header.css" />
    <link rel="stylesheet" href="/views/apoderado/css/conducta.css" />
    <link rel="shortcut icon" href="/views/apoderado/assets/img/logo_transparent.png" type="image/x-icon" />
    <script defer src="/views/apoderado/js/header.js"></script>
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
        <?php show_nav('Conducta') ?>
        <div class="container__section">
            <h2>Conducta</h2>
            <div class="section__table">
                <table>
                    <tr>
                        <th>Fecha</th>
                        <th>Estado</th>
                    </tr>
                    <tr>
                        <td>Hoy</td>
                        <td>
                            El alumno responde de manera grosera a compañeros. Segundo aviso
                        </td>
                    </tr>
                    <tr>
                        <td>22/04/2024</td>
                        <td>
                            El alumno responde de manera grosera a compañeros. Primer Aviso aviso
                        </td>
                    </tr>
                    <tr>
                        <td>19/04/2024</td>
                        <td>
                            El alumno le pegó a Juanito sin motivo algno además de agredirlo verbalmente usando expresiones groseras.
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </main>
</body>

</html>