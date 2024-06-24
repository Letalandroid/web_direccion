<?php

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] != 'Apoderado') {
    header('Location: /');
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/views/apoderado/css/header.css" />
    <link rel="stylesheet" href="/views/apoderado/css/conducta.css" />
    <link rel="shortcut icon" href="/views/apoderado/assets/img/logo_transparent.png" type="image/x-icon" />
    <script defer src="/views/apoderado/js/header.js"></script>
    <script src="/views/apoderado/js/conductas.js"></script>
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
        <div class="container__nav" style="display: flex; left: 0px;">
            <nav>
                <ul>
                    <li>
                        <i class="fas fa-chevron-right" aria-hidden="true"></i>
                        <a class="link__menu" href="/apoderado/asistencias">Asistencias</a>
                    </li>
                    <li>
                        <i class="fas fa-chevron-right" aria-hidden="true"></i>
                        <a class="link__menu" href="/apoderado/agenda">Agenda</a>
                    </li>
                    <li class="selected__page">
                        <i class="fas fa-chevron-right" aria-hidden="true"></i>
                        <a class="link__menu" href="/apoderado/notas">Notas</a>
                    </li>
                    <li>
                        <i class="fas fa-chevron-right" aria-hidden="true"></i>
                        <a class="link__menu" href="/apoderado/conducta">Conducta</a>
                    </li>
                </ul>
            </nav>
            <a href="/controllers/utils/closedSession.php?closed=true" id="closedSession">
                <i class="fas fa-door-open" aria-hidden="true"></i>
                Cerrar sesión
            </a>
        </div>
        </div>
        <div class="container__section">
            <h2>CONDUCTA</h2>
            <div class="container__conductas">
    <div class="section_conductas_bimestre1 sec_1">
        <div class="conductas_contain">
            <div>
                <h3>I Bimestre</h3>
            </div>
            <div>
                <p>Promedio:</p><span style="background-color: #ff8d00; color: #000;">B</span>
            </div>
            <button id="btn_1" onclick="btnActivate(1)" class="toggle-button">
                <i class="fas fa-chevron-right" aria-hidden="true"></i>
            </button>
        </div>
        <div class="notas__bim n__1">
            <div>
                <h3>Comentario:</h3>
                <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolore earum esse laborum rem est laboriosam cupiditate dolorem sapiente? Facilis ea aut dolores numquam quaerat magni vitae reprehenderit laboriosam nostrum fugit.</span>
            </div>
        </div>
    </div>

    <div class="section_conductas_bimestre1 sec_2">
        <div class="conductas_contain">
            <div>
                <h3>II Bimestre</h3>
            </div>
            <div>
                <p>Promedio:</p><span style="background-color: #ff8d00; color: #000;">B</span>
            </div>
            <button id="btn_2" onclick="btnActivate(2)" class="toggle-button">
                <i class="fas fa-chevron-right" aria-hidden="true"></i>
            </button>
        </div>
        <div class="notas__bim n__2">
            <div>
                <h3>Comentario:</h3>
                <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolore earum esse laborum rem est laboriosam cupiditate dolorem sapiente? Facilis ea aut dolores numquam quaerat magni vitae reprehenderit laboriosam nostrum fugit.</span>
            </div>
        </div>
    </div>

    <div class="section_conductas_bimestre1 sec_3">
        <div class="conductas_contain">
            <div>
                <h3>III Bimestre</h3>
            </div>
            <div>
                <p>Promedio:</p><span style="background-color: #ff8d00; color: #000;">B</span>
            </div>
            <button id="btn_3" onclick="btnActivate(3)" class="toggle-button">
                <i class="fas fa-chevron-right" aria-hidden="true"></i>
            </button>
        </div>
        <div class="notas__bim n__3">
            <div>
                <h3>Comentario:</h3>
                <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolore earum esse laborum rem est laboriosam cupiditate dolorem sapiente? Facilis ea aut dolores numquam quaerat magni vitae reprehenderit laboriosam nostrum fugit.</span>
            </div>
        </div>
    </div>

    <div class="section_conductas_bimestre1 sec_4">
        <div class="conductas_contain">
            <div>
                <h3>IV Bimestre</h3>
            </div>
            <div>
                <p>Promedio:</p><span style="background-color: #ff8d00; color: #000;">B</span>
            </div>
            <button id="btn_4" onclick="btnActivate(4)" class="toggle-button">
                <i class="fas fa-chevron-right" aria-hidden="true"></i>
            </button>
        </div>
        <div class="notas__bim n__4">
            <div>
                <h3>Comentario:</h3>
                <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolore earum esse laborum rem est laboriosam cupiditate dolorem sapiente? Facilis ea aut dolores numquam quaerat magni vitae reprehenderit laboriosam nostrum fugit.</span>
            </div>
        </div>
    </div>
</div>

        </div>
    </main>
</body>
</html>
