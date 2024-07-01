<?php

require_once __DIR__ . '/../../../controllers/Cita.php';
require_once __DIR__ . '/nav.php';

use Letalandroid\controllers\Cita;

$citas = Cita::getAllApo_Id($_SESSION['apoderado_id']);
$citas_vistas = Cita::getApo_Id($_SESSION['apoderado_id']);

?>

<header>
	<button onclick="closed_menu()"><i class="fas fa-bars"></i></button>
	<div class="logo__container">
		<a href="/apoderado">
			<img src="/views/apoderado/assets/img/logo.jpg" alt="logo_clavelitos_de_sjt" />
		</a>
	</div>
	<button onclick="showCitas()"><i class="fas fa-bell"></i></button>
	<div id="citas">
		<h4>Citas pendientes</h4>
		<ul>
			<li style="color: red" onclick="showAllCitas()">Citas anteriores</li>
			<?php foreach ($citas_vistas as $cita) { ?>
				<li onclick="showCita(<?= $cita['cita_id'] ?>, '<?= $cita['mensaje'] ?>')">
					<?= substr($cita['mensaje'], 0, 42) . '...' ?>
				</li>
			<?php } ?>
		</ul>
	</div>
	<div class="citas__container">
		<div class="citas__modal">
			<h3>Cita</h3>
			<p></p>
			<div class="closed_cita">
				<button onclick="closed_cita()">Cerrar</button>
			</div>
		</div>
	</div>
	<script>
		let show_citas = false;
		const citas_container = document.querySelector('#citas');
		const citas__container = document.querySelector('.citas__container');
		const all_citas = <?= json_encode($citas) ?? [] ?>;

		const showCitas = () => {
			if (!show_citas) {
				citas_container.style.display = 'block';
				show_citas = true;
			} else {
				citas_container.style.display = 'none';
				show_citas = false;
			}
		};


		const showAllCitas = () => {
			setCita(all_citas);
		}

		const showCita = async (id, desc) => {
			setCita(desc);

			const xhr = new XMLHttpRequest();
			xhr.open('POST', '/controllers/actions/docente/actionsCita.php');
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			xhr.onload = function() {
				if (xhr.status === 200) {
					console.log(xhr.response);
				} else {
					console.log(xhr.response);
				}
			};
			xhr.onerror = function() {
				console.error('Error de conexión');
			};

			const data_send = `
                setView=true&
                cita_id=${parseInt(id)}
            `;

			function customReplace(match) {
				if (match === '\n' || match === ' ') {
					return ' ';
				} else {
					return match;
				}
			}

			const replacedData = data_send.replace(/\n|\s+/g, customReplace);
			xhr.send(replacedData);
		};

		const setCita = (desc) => {

			const desc_json = JSON.parse(JSON.stringify(desc));
			console.log(desc_json);

			if (typeof desc_json === 'object') {
				let ul = document.createElement('ul');
				desc_json.forEach((item) => {
					let li = document.createElement('li');
					li.textContent = item.mensaje;
					ul.appendChild(li);
				});
				citas__container.querySelector('p').innerHTML = '';
				citas__container.querySelector('p').appendChild(ul);
			} else {
				citas__container.querySelector('p').textContent = desc;
			}
			citas__container.style.display = 'flex';
		};

		const closed_cita = () => {
			citas__container.style.display = 'none';
		};
	</script>
</header>