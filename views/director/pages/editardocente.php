<?php

use Letalandroid\controllers\Docente;

require_once __DIR__ . '/../../../controllers/Docente.php';

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] != 'Director') {
    header('Location: /');
    exit();
}

if (isset($_GET['id'])) {
    $docente_id = $_GET['id'];
    $docente = Docente::getById($docente_id);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $curso_id = $_POST['curso_id'];
        $dni = $_POST['dni'];
        $nombres = $_POST['nombres'];
        $apellidos = $_POST['apellidos'];
        $genero = $_POST['genero'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];

        $result = Docente::update($docente_id, $curso_id, $dni, $nombres, $apellidos, $genero, $fecha_nacimiento);

        if (isset($result['success'])) {
            header('Location: /views/director/pages/docentes.php?update=success');
            exit();
        } else {
            $error_message = $result['message'];
        }
    }
} else {
    header('Location: /views/director/pages/docentes.php');
    exit();
}
?>

<!DOCTYPE html>
    <html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/views/director/css/header.css" />
    <link rel="stylesheet" href="/views/director/css/docentes.css">
    <link rel="stylesheet" href="/views/director/css/datosdocente.css"> 
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
        <?php show_nav('Docente'); ?>
        <div class="container">
            <h1>Editar Datos de Docente</h1>
            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($error_message) ?>
                </div>
            <?php endif; ?>
            <form action="" method="POST" class="form__container">
                <div class="form__contrataciones">
                    <div class="form-group">
                        <label for="curso_id">Curso ID:</label>
                        <input type="number" id="curso_id" name="curso_id" value="<?= htmlspecialchars($docente['curso_id']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="dni">DNI:</label>
                        <input type="text" id="dni" name="dni" value="<?= htmlspecialchars($docente['dni']) ?>" onkeydown="return soloNumeros(event)" minlength="8" maxlength="8" required>
                        <script src="/views/director/js/home.js"></script>
                    </div>
                    <div class="form-group">
                        <label for="nombres">Nombres:</label>
                        <input type="text" id="nombres" name="nombres" value="<?= htmlspecialchars($docente['nombres']) ?>" onkeydown="return soloLetras(event)" maxlength="50" required>
                        <script src="/views/director/js/home.js"></script>
                    </div>
                    <div class="form-group">
                        <label for="apellidos">Apellidos:</label>
                        <input type="text" id="apellidos" name="apellidos" value="<?= htmlspecialchars($docente['apellidos']) ?>" onkeydown="return soloLetras(event)" maxlength="50" required>
                        <script src="/views/director/js/home.js"></script>
                    </div>
                    <div class="form-group">
                        <label for="genero">Género:</label>
                        <input type="text" id="genero" name="genero" value="<?= htmlspecialchars($docente['genero']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?= htmlspecialchars($docente['fecha_nacimiento']) ?>" required>
                    </div>
                </div>
                <div class="form-buttons">
                    <input type="submit" name="update" class="btn agregar" value="Actualizar">
                    <button type="button" class="btn limpiar" onclick="window.location.href='/views/director/pages/docentes.php'">Cancelar</button>
                </div>
            </form>
        </div>
    </main>
</body>

</html>