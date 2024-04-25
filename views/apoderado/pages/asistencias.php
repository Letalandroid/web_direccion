<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/views/apoderado/css/header.css" />
    <link rel="stylesheet" href="/views/apoderado/css/asistencias.css" />
    <script defer src="/views/apoderado/components/header.js"></script>
    <script defer src="/views/apoderado/components/nav.js"></script>
    <link rel="shortcut icon" href="/views/apoderado/assets/img/logo_transparent.png" type="image/x-icon" />
    <script defer src="/views/apoderado/js/header.js"></script>
    <script defer>
        document.addEventListener("DOMContentLoaded", () => {
            nav('Asistencias');
            closed_menu();
        });
    </script>
    <script src="https://kit.fontawesome.com/8b1c082df7.js" crossorigin="anonymous"></script>
    <title>I.E.P Los Clavelitos de SJT - Piura | Asistencias</title>
</head>

<body>
    <main>
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