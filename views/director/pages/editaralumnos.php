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


if (isset($_GET['id'])) {
    $alumno_id = $_GET['id'];
    $alumnos = Alumnos::getById($alumno_id);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $apoderado_id = $_POST['apoderado_id'];
        $dni = $_POST['dni'];
        $nombres = $_POST['nombres'];
        $apellidos = $_POST['apellidos'];
        $genero = $_POST['genero'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
        $aula_id = $_POST['aula_id'];
        $grado = $_POST['grado'];
        $seccion = $_POST['seccion'];
        $nivel = $_POST['nivel'];

        $result = Alumnos::update($alumno_id, $apoderado_id, $dni, $nombres, $apellidos, $genero, $fecha_nacimiento, $aula_id, $grado, $seccion, $nivel);

        if (isset($result['success'])) {
            header('Location: /views/director/pages/alumnos.php?update=success');
            exit();
        } else {
            $error_message = $result['message'];
        }
    }
} else {
    header('Location: /views/director/pages/alumnos.php');
    exit();
}

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
        <div class="container">
            <h1>Editar Datos de Alumno</h1>
            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($error_message) ?>
                </div>
            <?php endif; ?>
            <form action="" method="POST" class="form__container">
                <div class="form__contrataciones">
                    <div class="form-group">
                        <label for="curso_id">Apoderado ID:</label>
                        <input disabled selected type="number" id="apoderado_id" name="apoderado_id" value="<?= htmlspecialchars($alumnos['apoderado_id']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="dni">DNI:</label>
                        <input type="text" id="dni" name="dni" value="<?= htmlspecialchars($alumnos['dni']) ?>" onkeydown="return soloNumeros(event)" minlength="8" maxlength="8" required>
                        <script src="/views/director/js/home.js"></script>
                    </div>
                    <div class="form-group">
                        <label for="nombres">Nombres:</label>
                        <input type="text" id="nombres" name="nombres" value="<?= htmlspecialchars($alumnos['nombres']) ?>" onkeydown="return soloLetras(event)" maxlength="50" required>
                        <script src="/views/director/js/home.js"></script>
                    </div>
                    <div class="form-group">
                        <label for="apellidos">Apellidos:</label>
                        <input type="text" id="apellidos" name="apellidos" value="<?= htmlspecialchars($alumnos['apellidos']) ?>" onkeydown="return soloLetras(event)" maxlength="50" required>
                        <script src="/views/director/js/home.js"></script>
                    </div>
                    <div class="form-group">
                        <label for="genero">Género:</label>
                        <input type="text" id="genero" name="genero" value="<?= htmlspecialchars($alumnos['genero']) ?>" onkeydown="return soloLetras(event)" required>
                        <script src="/views/director/js/home.js"></script>
                    </div>
                    <div class="form-group">
                        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?= htmlspecialchars($alumnos['fecha_nacimiento']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="aula_id">Aula ID:</label>
                        <input disabled selected type="number" id="aula_id" name="aula_id" value="<?= htmlspecialchars($alumnos['aula_id']) ?>" onkeydown="return soloNumeros(event)" required>
                        <script src="/views/director/js/home.js"></script>
                    </div>
                    <div class="form-group">
                        <label for="grado">Grado:</label>
                        <input type="text" id="grado" name="grado" value="<?= htmlspecialchars($alumnos['grado']) ?>" onkeydown="return soloNumeros(event)" min="1" max="6" required>
                        <script src="/views/director/js/home.js"></script>
                    </div>
                    <div class="form-group">
                        <label for="seccion">Sección:</label>
                        <input type="text" id="seccion" name="seccion" value="<?= htmlspecialchars($alumnos['seccion']) ?>" onkeydown="return soloLetras(event)" maxlength="1" required>
                        <script src="/views/director/js/home.js"></script>
                    </div>
                    <div class="form-group">
                        <label for="nivel">Nivel:</label>
                        <input type="text" id="nivel" name="nivel" value="<?= htmlspecialchars($alumnos['nivel']) ?>" onkeydown="return soloLetras(event)" required>
                        <script src="/views/director/js/home.js"></script>
                    </div>
                </div>
                <div class="form-buttons">
                    <input type="submit" name="update" class="btn agregar" value="Actualizar">
                    <button type="button" class="btn limpiar" onclick="window.location.href='/views/director/pages/alumnos.php'">Cancelar</button>
                </div>
            </form>
        </div>
    </main>
</body>

</html>
