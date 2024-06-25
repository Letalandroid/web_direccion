<?php

use Letalandroid\controllers\Cursos;
use Letalandroid\controllers\Notas;

require_once __DIR__ . '/../../../controllers/Cursos.php';
require_once __DIR__ . '/../../../controllers/Notas.php';

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] != 'Docente') {
    header('Location: /');
    exit();
}

$cursos = Cursos::getForIdDoc($_SESSION['docente_id']);
$alumnos = [];

foreach ($cursos as $curso) {
    $alumnos += Notas::getAll_Course_Conduct($curso['curso_id']);
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
            <div id="reload">
                <p>Parece que hay nuevos cambios, se sugiere <button onclick="location.reload();">recargar</button></p>
            </div>
            <h2>CONDUCTA</h2>
            <div class="controls">
                <div class="dropdown">
                    <label for="curso">Curso:</label>
                    <select id="curso">
                        <?php foreach ($cursos as $curso) { ?>
                            <option value="<?= $curso['curso_id'] ?>"><?= $curso['nombre'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="dropdown">
                    <label for="unidad">Unidad:</label>
                    <select id="unidad">
                        <option value="1">Primer bimestre</option>
                        <option value="2">Segundo bimestre</option>
                        <option value="3">Tercer bimestre</option>
                        <option value="4">Cuarto bimestre</option>
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
                <button class="btn buscar"><i class="fas fa-search"></i>Buscar</button>
                <button onclick="enviarNota()" class="btn guardar"><i class="fas fa-save"></i>Guardar</button>
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
                        <input maxlength="1" type="text" id="calificacion">
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
    <script>
        const alumnos = <?= json_encode($alumnos); ?>;
        const curso_id = document.querySelector('#curso');
        const unidad = document.querySelector('#unidad');
        const alumno = document.querySelector('#alumno');
        const calificacion = document.querySelector('#calificacion');
        const nota = document.querySelector('#nota');

        const limpiar = (note) => {
            document.querySelector(`#${note}`).value = 0;
        }

        function cargarAlumnos() {
            const cursoSeleccionado = document.getElementById('curso').value;
            const listaAlumnos = document.getElementById('alumno');

            listaAlumnos.innerHTML = '';

            const alumnosFiltrados = alumnos.reduce((acc, alumno) => {
                if (alumno.alumno_id === null) {
                    // Conserva los registros con alumno_id null
                    acc.push({
                        alumno_id: alumno.alumno_id,
                        nombres_apellidos: alumno.nombres_apellidos,
                        curso_id: alumno.curso_id,
                        bimestre: alumno.bimestre
                        // Agrega aquí las demás propiedades que necesites
                    });sadsadasd
                    if (existingAlumno) {
                        // Si existe, agrega las propiedades que no están aún en el registro existente
                        Object.keys(alumno).forEach(key => {
                            if (!existingAlumno.hasOwnProperty(key)) {
                                existingAlumno[key] = alumno[key];
                            }
                        });
                    } else {dad].descripcion ?? '';
        }

        cargarAlumnos();

        const enviarNota = () => {

            let succesdsa{
                if (xhr.status === 200) {
                    console.log(xhr.response);
                    success += 1;
                } else {
                    console.log(xhr.response);
                    error += 1;
                }

                document.querySelector('#reload').innerHTML = `
				<b>($d
                unidad=${unidad.value}&
                alumno_id=${alumno.value}&
                calificacion=${calificacion.value}&
                nota=${nota.value}
            `;

            function customReplace(match) {
                if (match === '\n' || match === ' ') {
                    return ' ';
             dsadas
        }
    </script>
</body>

</html>