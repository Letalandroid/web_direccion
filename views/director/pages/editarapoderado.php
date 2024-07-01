<?php

use Letalandroid\controllers\Apoderado;

require_once __DIR__ . '/../../../controllers/Apoderado.php';

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] != 'Director') {
    header('Location: /');
    exit();
}

$apoderados_con = Apoderado::getAllCon();
$apoderados_reverse = Apoderado::getAllReverse();
$apoderados_sin = Apoderado::getAllSinAlumn();

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
    <link rel="stylesheet" href="/views/director/css/apoderado.css">
    <link rel="shortcut icon" href="/views/director/assets/img/logo_transparent.png" type="image/x-icon" />
    <script defer src="/views/director/js/header.js"></script>
    <script defer>
        document.addEventListener("DOMContentLoaded", () => {
            closed_menu();
        });
    </script>
    <script src="https://kit.fontawesome.com/8b1c082df7.js" crossorigin="anonymous"></script>
    <title>I.E.P Los Clavelitos de SJT - Piura | Apoderados</title>
</head>

<body>
    <?php require_once __DIR__ . '/../components/header.php' ?>
    <main>
        <?php show_nav('Apoderados'); ?>
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
                        <input type="number" id="apoderado_id" name="apoderado_id" value="<?= htmlspecialchars($alumnos['apoderado_id']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="dni">DNI:</label>
                        <input type="text" id="dni" name="dni" value="<?= htmlspecialchars($alumnos['dni']) ?>" minlength="8" maxlength="8" required>
                    </div>
                    <div class="form-group">
                        <label for="nombres">Nombres:</label>
                        <input type="text" id="nombres" name="nombres" value="<?= htmlspecialchars($alumnos['nombres']) ?>" maxlength="50" required>
                    </div>
                    <div class="form-group">
                        <label for="apellidos">Apellidos:</label>
                        <input type="text" id="apellidos" name="apellidos" value="<?= htmlspecialchars($alumnos['apellidos']) ?>" maxlength="50" required>
                    </div>
                    <div class="form-group">
                        <label for="genero">Género:</label>
                        <input type="text" id="genero" name="genero" value="<?= htmlspecialchars($alumnos['genero']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?= htmlspecialchars($alumnos['fecha_nacimiento']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="aula_id">Telefono:</label>
                        <input type="number" id="telefono" name="telefono" value="<?= htmlspecialchars($alumnos['telefono']) ?>" minlength="9" maxlength="9" required>
                    </div>
                    <div class="form-group">
                        <label for="grado">Correo:</label>
                        <input type="text" id="correo" name="correo" value="<?= htmlspecialchars($alumnos['correo']) ?>" maxlength="100" required>
                    </div>
                </div>
                <div class="form-buttons">
                    <input type="submit" name="update" class="btn agregar" value="Actualizar">
                    <button type="button" class="btn limpiar" onclick="window.location.href='/views/director/pages/apoderados.php'">Cancelar</button>
                </div>
            </form>
        </div>
    </main>
</body>

</html>
