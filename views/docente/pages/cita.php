<?php

use Letalandroid\controllers\Apoderado;

require_once __DIR__ . '/../../../controllers/Apoderado.php';


session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] != 'Docente') {
    header('Location: /');
    exit();
}

$apoderados = Apoderado::getAllFormat();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/views/docente/css/header.css" />
    <link rel="stylesheet" href="/views/docente/css/cita.css">
    <link rel="shortcut icon" href="/views/docente/assets/img/logo_transparent.png" type="image/x-icon" />
    <script defer src="/views/docente/js/header.js"></script>
    <script defer>
        document.addEventListener("DOMContentLoaded", () => {
            closed_menu();
        });
    </script>
    <script src="https://kit.fontawesome.com/8b1c082df7.js" crossorigin="anonymous"></script>
    <title>I.E.P Los Clavelitos de SJT - Piura | Cita</title>
</head>

<body>
    <?php require_once __DIR__ . '/../components/header.php' ?>
    <main>
        <?php show_nav('Cita'); ?>
        <div class="container__section">
            <div id="reload">
                <p>Parece que hay nuevos cambios, se sugiere <button onclick="location.reload();">recargar</button></p>
            </div>
            <div class="create__agenda">
                <h3>CITA</h3>
                <div class="container__data_agenda">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Apoderados:</label>
                            <input list="apoderados" id="apoderado" placeholder="<?= $apoderados[0]['dni'] . ' - ' . $apoderados[0]['nombres_apellidos'] ?>" required>
                            <datalist id="apoderados">
                                <?php foreach ($apoderados as $apoderado) { ?>
                                    <option value="<?= $apoderado['dni'] . ' - ' . $apoderado['nombres_apellidos'] ?>">
                                    </option>
                                <?php } ?>
                            </datalist>
                        </div>
                        <div class="form-group">
                            <label>Fecha:</label>
                            <input id="fecha_actividad" class="send_data" type="date">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Descripción:</label>
                            <textarea id="descripcion" class="send_data" type="text"></textarea>
                        </div>
                    </div>
                    <div class="form-row" id="button-container">
                        <button id="clear-button" onclick="location.href = '/docente'"><i class="fas fa-trash-alt"></i>Regresar</button>
                        <button id="add-button" onclick="addCita()"><i class="fas fa-plus-square"></i>Enviar Cita</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        const addCita = async () => {
            let isEmpty = false;
            document.querySelector('#reload').style.display = 'none';

            document.querySelectorAll('.send_data').forEach((data) => {
                if (data.value.length <= 0 || data.value.startsWith(' ')) {
                    isEmpty = true;
                    return;
                }
            });

            if (!isEmpty && confirm('¿Los datos a enviar son correctos?')) {
                const descripcion = document.querySelector('#descripcion').value;
                const apoderado = document.querySelector('#apoderado').value;
                const fecha_actividad = document.querySelector('#fecha_actividad').value;
                const mensaje = `Se le cita al apoderado el día ${fecha_actividad} por el siguiente motivo: ${descripcion}`;

                const xhr = new XMLHttpRequest();
                xhr.open('POST', '/../../../controllers/actions/docente/actionsCita.php');
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        console.log(xhr.response);
                        document.querySelector('#reload').style.display = 'block';
                        alert('Cita agendada exitosamente!');
                    } else {
                        console.log(xhr.response);
                    }
                };
                xhr.onerror = function() {
                    console.error('Error de conexión');
                };
                console.log(`createAgenda=true&docente_id${<?= $_SESSION['docente_id'] ?>}&mensaje=${mensaje}&apoderado_dni=${apoderado.split(' - ')[0]}`);
                xhr.send(`createCita=true&docente_id=${<?= $_SESSION['docente_id'] ?>}&mensaje=${mensaje}&apoderado_dni=${apoderado.split(' - ')[0]}`);
            } else {
                alert('Existen uno o más campos vacío.');
            }
        }

        // Para Limpiar Fecha, Curso y descripcion
        const clearForm = () => {
            document.getElementById('fecha_actividad').value = '';
            document.getElementById('curso').selectedIndex = 0;
            document.getElementById('descripcion').value = '';
        };
    </script>
</body>

</html>