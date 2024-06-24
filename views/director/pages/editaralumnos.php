<?php

use Letalandroid\controllers\Alumnos;
use Letalandroid\controllers\Apoderado;
use Letalandroid\controllers\Cursos;

require_once __DIR__ . '/../../../controllers/Alumnos.php';
require_once __DIR__ . '/../../../controllers/Apoderado.php';
require_once __DIR__ . '/../../../controllers/Cursos.php';

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] != 'Director') {
    header('Location: /');
    exit();
}



$alumnos = Alumnos::getAllMin();
$apoderados = Apoderado::getAllFormat();
$cursos = Cursos::getAll();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/views/director/css/header.css" />
    <link rel="stylesheet" href="/views/director/css/editaralumnos.css">
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
        <?php show_nav('Alumnos'); ?>
        
    <div class="form-container">
        <h1>EDIT ALUMNOS</h1>
        <form>
            <div class="form-row">
                <div class="form-group">
                    <label for="dni">DNI:</label>
                    <input type="text" id="dni" name="dni" value="<?php echo $alumnos[0]['dni'] ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="nombres">Nombres</label>
                    <input type="text" id="nombres" name="nombres" value="<?php echo $alumnos[0]['nombres'] ?>"">
                </div>
                <div class="form-group">
                    <label for="genero">Género:</label>
                    <select id="genero" name="genero">
                        <option value="">Seleccionar Género</option>
                        <option value="Masculino" <?php echo ($alumnos[0]['genero'] == 'Masculino') ? 'selected' : ''; ?>>Masculino</option>
                        <option value="Femenino" <?php echo ($alumnos[0]['genero'] == 'Femenino') ? 'selected' : ''; ?>>Femenino</option>
                        <option value="otro" <?php echo ($alumnos[0]['genero'] == 'otro') ? 'selected' : ''; ?>>Otro</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="apellidos">Apellidos</label>
                    <input type="text" id="apellidos" name="apellidos" value="<?= $alumnos[0]['apellidos'] ?>">
                </div>
                <div class="form-group">
                    <label for="fecha_nacimiento">Fecha de nacimiento</label>
                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?= $alumnos[0]['fecha_nacimiento'] ?>">
                </div>
            </div>
            <div class="button-group">
                <button type="submit" class="btn btn-save">Guardar</button>
                <button type="reset" class="btn btn-clear">Limpiar</button>
                <button type="button" class="btn btn-back" onclick="window.location.href='/views/director/pages/alumnos.php'">Regresar</button>
            </div>
        </form>
    </div>
    </main>
</body>

</html>
