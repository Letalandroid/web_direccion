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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/views/docente/css/header.css" />
    <link rel="stylesheet" href="/views/docente/css/conducta.css" />
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
        <?php show_nav('Conducta') ?>
        <div class="container__section">
            <h2>CONDUCTA</h2>
            <div class="controls">
                <div class="dropdown">
                    <label for="unidad">Unidad:</label>
                    <select id="unidad">
                        <option>Seleccionar unidad</option>
                        
                    </select>
                </div>
                <div class="dropdown">
                    <label for="alumno">Alumno:</label>
                    <select id="alumno">
                        <option>Seleccionar alumno</option>
                        
                    </select>
                </div>
                </div>
                <div class="buttons">
                    <button class="btn buscar"><i class="fas fa-search"></i> Buscar</button>
                    <button class="btn guardar"><i class="fas fa-save"></i> Guardar</button>
                </div>
            
            <div class="section__table">
            <form>
                <div class="form-group">
                    <label>Bimestre </label>
                    <label>Nota</label>
                    <label>Limpiar</label>
                </div>
                <div class="form-group">
                    <label for="calificacion">Calificación</label>
                    <input type="text" id="calificacion">
                    <button class="btn eliminar"><i class="fa fa-trash"></i></button>
                </div>
                <div class="form-group">
                    <label for="nota">Nota:</label>
                    <textarea id="nota"></textarea>
                    <button class="btn eliminar"><i class="fa fa-trash"></i></button>
                </div>
            </form>
            </div>
        </div>
    </main>
</body>

</html>