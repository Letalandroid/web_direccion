<?php

use Letalandroid\controllers\Cursos;
use Letalandroid\controllers\Agenda;

require_once __DIR__ . '/../../../controllers/Cursos.php';
require_once __DIR__ . '/../../../controllers/Agenda.php';

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] != 'Docente') {
    header('Location: /');
    exit();
}

if (isset($_GET['id'])) {
    $evento_id = $_GET['id'];
    $agenda = Agenda::getById($evento_id);
    $cursos = Cursos::getForIdDoc($_SESSION['docente_id']);
} else {
    // Redirige o muestra un mensaje de error si no hay ID
    header('Location: /views/docente/pages/agenda.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/views/docente/css/header.css" />
    <link rel="stylesheet" href="/views/docente/css/agendaEditar.css">
    <link rel="shortcut icon" href="/views/docente/assets/img/logo_transparent.png" type="image/x-icon" />
    <script defer src="/views/docente/js/header.js"></script>
    <script defer src="/views/docente/js/header.js"></script>
    <script defer>
        document.addEventListener("DOMContentLoaded", () => {
            closed_menu();
        });
    </script>
    <script src="https://kit.fontawesome.com/8b1c082df7.js" crossorigin="anonymous"></script>
    <title>I.E.P Los Clavelitos de SJT - Piura | Editar Actividad</title>
</head>

<body>
    <?php require_once __DIR__ . '/../components/header.php' ?>
    <main>
        <?php show_nav('Agenda'); ?>
        <div class="container__section">
            <div class="create__agenda">
                <h3>EDITAR AGENDA</h3>
                <?php
                if (isset($_GET['update']) && $_GET['update'] === 'success') {
                    echo '<div class="alert alert-success" role="alert">
                            Actividad actualizada exitosamente.
                          </div>';
                }
                ?>
                <div class="container__data_agenda">
                    <form action="/controllers/actions/docente/actionsAgenda.php" method="POST">
                        <input type="hidden" name="updateAgenda" value="1">
                        <input type="hidden" class="form-control mb-3" name="evento_id" value="<?= htmlspecialchars($agenda['evento_id']) ?>">
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="curso_id">Curso:</label>
                                <select class="form-control mb-3" name="curso_id" id="curso_id" required>
                                    <?php foreach ($cursos as $curso) { ?>
                                        <option value="<?= htmlspecialchars($curso['curso_id']) ?>" <?= $curso['curso_id'] == $agenda['curso_id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($curso['nombre']) ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="fecha_evento">Fecha:</label>
                                <input type="date" class="form-control mb-3" name="fecha_evento" id="fecha_evento" value="<?= htmlspecialchars($agenda['fecha_evento']) ?>" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="descripcion">Descripción:</label>
                                <textarea class="form-control mb-3" name="descripcion" id="descripcion" required><?= htmlspecialchars($agenda['descripcion']) ?></textarea>
                            </div>
                        </div>

                        <div id="button-container">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Actualizar</button>
                            <button type="button" class="btn btn-danger" onclick="window.location.href='/views/docente/pages/agenda.php';"><i class="fas fa-times"></i> Cancelar</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </main>
    <script>

// Manejo de actualización de la agenda
const form = document.getElementById('updateAgendaForm');
            form.addEventListener('submit', function(event) {
                event.preventDefault(); 

                const formData = new FormData(form);
                const xhr = new XMLHttpRequest();
                xhr.open('POST', form.action);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            alert('Actividad actualizada exitosamente');
                            window.location.href = '/views/docente/pages/agenda.php';
                        } else {
                            alert('Error al actualizar la actividad: ' + response.message);
                        }
                    } else {
                        alert('Error al actualizar la actividad');
                        console.error(xhr.response);
                    }
                };
                xhr.onerror = function() {
                    alert('Error de conexión');
                    console.error('Error de conexión');
                };
                xhr.send(new URLSearchParams(formData).toString());
            });
</script>


</body>

</html>