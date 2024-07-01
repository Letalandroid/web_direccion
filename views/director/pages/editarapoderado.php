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
    $apoderado_id = $_GET['id'];
    $apoderado = Apoderado::getById($apoderado_id);



} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dni = $_POST['dni'];
    $apoderado_id = $_POST['apoderado_id'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $genero = $_POST['genero'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];

    $result = Apoderado::update($apoderado_id, $dni, $nombres, $apellidos, $genero, $fecha_nacimiento, $telefono, $correo);

    if (isset($result['success'])) {
        header('Location: /views/director/pages/apoderados.php?update=success');
        exit();
    } else {
        echo  $result['message'];
    }
}
else{
    
    header('Location: /director');
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
            <h1>Editar Datos de Apoderado</h1>
            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($error_message) ?>
                </div>
            <?php endif; ?>
            <form action="/views/director/pages/editarapoderado.php" method="POST" class="form__container">
                <div class="form__contrataciones">
                    <div class="form-group">
                        <label for="dni">Apoderado ID:</label>
                        <input type="text" id="apoderado_id" name="apoderado_id" value="<?= htmlspecialchars($apoderado[0]['apoderado_id']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="dni">DNI:</label>
                        <input type="text" id="dni" name="dni" value="<?= htmlspecialchars($apoderado[0]['dni']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="nombres">Nombres:</label>
                        <input type="text" id="nombres" name="nombres" value="<?= htmlspecialchars($apoderado[0]['nombres']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="apellidos">Apellidos:</label>
                        <input type="text" id="apellidos" name="apellidos" value="<?= htmlspecialchars($apoderado[0]['apellidos']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="genero">Género:</label>
                        <input type="text" id="genero" name="genero" value="<?= htmlspecialchars($apoderado[0]['genero']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label> for="fecha_nacimiento">Fecha de Nacimiento:</label>
                        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?= htmlspecialchars($apoderado[0]['fecha_nacimiento']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="grado">Telefono:</label>
                        <input type="text" id="telefono" name="telefono" value="<?= htmlspecialchars($apoderado[0]['telefono']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="seccion">Correo:</label>
                        <input type="text" id="correo" name="correo" value="<?= htmlspecialchars($apoderado[0]['correo']) ?>" required>
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

<?php