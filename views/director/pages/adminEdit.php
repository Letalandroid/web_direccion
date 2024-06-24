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
    $docente = Docente::getAllMin($docente_id);

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
    <link rel="stylesheet" href="/views/director/css/administracion.css">
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
        <?php show_nav('administracion'); ?>
        <div class="container__principal">
            <h1>EDITAR DOCENTE</h1>
            <?php if (isset($error_message)): ?>
                <p class="error"><?php echo $error_message; ?></p>
            <?php endif; ?>
            <form class="form" method="POST">
                <div class="row">
                    <div class="column">
                        <label for="dni">DNI:</label>
                        <input type="text" id="dni" name="dni" value="<?php echo isset($docente['dni']) ? $docente['dni'] : ''; ?>">
                    </div>
                    <div class="column">
                        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo isset($docente['fecha_nacimiento']) ? $docente['fecha_nacimiento'] : ''; ?>" placeholder="dd/mm/aaaa">
                    </div>
                </div>
                <div class="row">
                    <div class="column">
                        <label for="nombres">Nombres:</label>
                        <input type="text" id="nombres" name="nombres" value="<?php echo isset($docente['nombres']) ? $docente['nombres'] : ''; ?>">
                    </div>
                    <div class="column">
                        <label for="genero">Género:</label>
                        <select id="genero" name="genero">
                            <option value="">Seleccionar género</option>
                            <option value="Masculino" <?php echo (isset($docente['genero']) && $docente['genero'] == 'Masculino') ? 'selected' : ''; ?>>Masculino</option>
                            <option value="Femenino" <?php echo (isset($docente['genero']) && $docente['genero'] == 'Femenino') ? 'selected' : ''; ?>>Femenino</option>
                            <!-- Opciones de género adicionales -->
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="column">
                        <label for="apellidos">Apellidos:</label>
                        <input type="text" id="apellidos" name="apellidos" value="<?php echo isset($docente['apellidos']) ? $docente['apellidos'] : ''; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="buttons-right">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> ACTUALIZAR</button>
                    <button type="button" class="btn btn-danger" onclick="window.location.href='/views/director/pages/administracion.php';"><i class="fas fa-times"></i> CANCELAR</button>

                        
                            

                    </div>
                </div>
            </form>
        </div>
    </main>
</body>

</html>

