<?php

use Letalandroid\controllers\Notas;
use Letalandroid\controllers\Alumnos;

require_once __DIR__ . '/../../../controllers/Alumnos.php';
require_once __DIR__ . '/../../../controllers/Notas.php';

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] != 'Apoderado') {
	header('Location: /');
	exit();
}

$alumno_id = Alumnos::getAll_Apo((int) $_SESSION['apoderado_id'])[0]['alumno_id'];
$notas = Notas::getAll_Aulm($alumno_id);

?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="/views/apoderado/css/header.css" />
	<link rel="stylesheet" href="/views/apoderado/css/notas.css" />
	<link rel="shortcut icon" href="/views/apoderado/assets/img/logo_transparent.png" type="image/x-icon" />
	<script defer src="/views/apoderado/js/header.js"></script>
	<script>
		console.log(<?= json_encode($notas) ?>)
	</script>
	<script defer>
		document.addEventListener('DOMContentLoaded', () => {
			closed_menu();
		});
	</script>
	<script src="https://kit.fontawesome.com/8b1c082df7.js" crossorigin="anonymous"></script>
	<title>I.E.P Los Clavelitos de SJT - Piura</title>
</head>

<body>
	<?php require_once __DIR__ . '/../components/header.php' ?>
	<main>
		<?php show_nav('Notas') ?>
		<div class="container__section">
			<h2>Mis notas:</h2>
			<div class="container__notas"></div>
		</div>
	</main>
	<script>
		// Supongamos que tenemos las notas provenientes de PHP en la variable 'notas'
		const notas = <?= json_encode($notas) ?>;

		// Transformación de datos
		const transformarDatos = (datos) => {
			const cursosMap = new Map();

			// Iterar sobre cada nota
			datos.forEach(dato => {
				const key = dato.curso_id;
				if (!cursosMap.has(key)) {
					cursosMap.set(key, {
						id: key,
						curso: dato.nombre,
						notas_bimestres: []
					});
				}

				const curso = cursosMap.get(key);

				// Asegurar que notas_bimestres tiene suficiente longitud
				while (curso.notas_bimestres.length < dato.bimestre) {
					curso.notas_bimestres.push({
						practica: 0,
						participacion: 0,
						examen: 0
					});
				}

				// Actualizar la nota correspondiente al bimestre
				const notasBimestre = curso.notas_bimestres[dato.bimestre - 1];
				switch (dato.tipo) {
					case "Practica":
						notasBimestre.practica = dato.valor;
						break;
					case "Participacion":
						notasBimestre.participacion = dato.valor;
						break;
					case "Examen":
						notasBimestre.examen = dato.valor;
						break;
					default:
						break;
				}
			});

			return Array.from(cursosMap.values());
		};

		const calcularPromedioYColor = (nPractica, nParticipacion, nExamen) => {
			const promedio = (nPractica + nParticipacion + nExamen) / 3;
			let color;

			if (promedio >= 18 && promedio <= 20) {
				color = '#2fbf65';
			} else if (promedio >= 15 && promedio < 18) {
				color = '#39E379';
			} else if (promedio >= 11 && promedio < 15) {
				color = '#ff8d00';
			} else if (promedio >= 0 && promedio < 11) {
				color = '#f00';
			}

			return {
				promedio,
				color
			};
		};

		// Transformar los datos obtenidos de PHP
		const notasTransformadas = transformarDatos(notas);

		// Mostrar resultados en HTML
		const container_notes = document.querySelector('.container__notas');
		let contenido = '';

		notasTransformadas.forEach((notas, index) => {
			let notas_bimestre = '';

			// Variable para calcular el promedio general del curso
			let totalPractica = 0;
			let totalParticipacion = 0;
			let totalExamen = 0;

			notas.notas_bimestres.forEach((nBim, index) => {
				notas_bimestre += `
            <div>
                <h3>${index + 1} Bimestre:</h3>
                <span>Participación: ${nBim.participacion}</span>
                <span>Práctica: ${nBim.practica}</span>
                <span>Examen Bimestral: ${nBim.examen}</span>
            </div>
        `;

				// Acumular las notas para calcular el promedio general del curso
				totalPractica += nBim.practica;
				totalParticipacion += nBim.participacion;
				totalExamen += nBim.examen;
			});

			// Calcular el promedio general del curso
			const cantidadBimestres = notas.notas_bimestres.length;
			const promedioGeneral = {
				practica: totalPractica / cantidadBimestres,
				participacion: totalParticipacion / cantidadBimestres,
				examen: totalExamen / cantidadBimestres
			};

			const {
				promedio,
				color
			} = calcularPromedioYColor(promedioGeneral.practica, promedioGeneral.participacion, promedioGeneral.examen);


			contenido += `
        <div class="section__notas sec_${notas.id}">
            <div class='notas__contain'>
                <div>
                    <i class="fas fa-book-open"></i>
                    <h3>${notas.curso}</h3>
                </div>
				<div>
                    <p>Promedio General:</p>
                    <span style='background-color: ${color};'>${promedio.toFixed(2)}</span>
                </div>
            </div>
            <div class='notas__bim n__${notas.id}'>
                ${notas_bimestre}
            </div>
			<button id='btn_${notas.id}' onclick='btnActivate(${notas.id})'><i class="fas fa-chevron-right"></i></button>
        </div>`;
		});

		// Insertar contenido generado en el contenedor HTML
		container_notes.innerHTML += contenido;

		const btnActivate = (id) => {

			const btnActivate = document.querySelector(`#btn_${id}`);
			const container_activate = document.querySelector(`.n__${id}`);
			const section_notes = document.querySelector(`.sec_${id}`);

			container_activate.classList.toggle('activate');
			btnActivate.classList.toggle('activate_btn');
			section_notes.classList.toggle('sparcing');

		}
	</script>
</body>

</html>