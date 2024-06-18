const asistencias = document.querySelectorAll('.asistencia');
const nombres_apellidos = document.querySelector('#nombres_apellidos');
const id_curso = document.querySelector('#id_curso');
const year = document.querySelector('#year');
const loader = document.querySelector('#loader');

var fechaActual = new Date();

// Formatear la fecha en el formato YYYY-MM-DD
var formatoFecha =
	fechaActual.getFullYear() +
	'-' +
	('0' + (fechaActual.getMonth() + 1)).slice(-2) +
	'-' +
	('0' + fechaActual.getDate()).slice(-2);

year.value = formatoFecha;

const showJustify = (a) => {
	const desc_justificado = document.querySelector(
		`#desc_justificado_${a.classList[2]}`
	);

	if (a.classList.contains('justificado')) {
		desc_justificado.hidden = false;
	} else {
		desc_justificado.hidden = true;
	}
};

const marcarAsistencia = () => {
	const all_presents = document.querySelectorAll('.presente');
	const desc_justificacion = document.querySelectorAll('.desc_justificacion');

	all_presents.forEach((v) => {
		v.checked = true;
	});

	desc_justificacion.forEach((desc) => {
		desc.hidden = true;
	});
};

const marcarFalta = () => {
	const all_ausents = document.querySelectorAll('.falta');
	const desc_justificacion = document.querySelectorAll('.desc_justificacion');

	all_ausents.forEach((v) => {
		v.checked = true;
	});

	desc_justificacion.forEach((desc) => {
		desc.hidden = true;
	});
};

const enviarAsistencia = async () => {
	const asistenciasRows = document.querySelectorAll('tr.asistencias');
	let success = 0;
	let error = 0;

	for (const row of asistenciasRows) {
		const alumnoId = row.querySelector('input[type="number"]').value;
		const asistencias = row.querySelectorAll('.asistencia');
		const motivo = document.querySelector(
			`#desc_justificado_${alumnoId} .motivo`
		);

		const getAsistencia = () => {
			for (const a of asistencias) {
				if (a.checked) {
					if (a.classList.contains('presente'))
						return {
							estado: 'Presente',
						};
					if (a.classList.contains('falta'))
						return {
							estado: 'Faltó',
						};
					if (a.classList.contains('justificado'))
						return {
							estado: 'Justificado',
							motivo: motivo.value,
						};
				}
			}
		};

		loader.style.display = 'flex';
		const xhr = new XMLHttpRequest();
		xhr.open('POST', '/controllers/actions/docente/actionsAsistencias.php');
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.onload = function () {
			if (xhr.status === 200) {
				console.log(xhr.response);
				success += 1;
			} else {
				console.log(xhr.response);
				error += 1;
			}

			loader.style.display = 'none';
			document.querySelector('#reload').innerHTML = `
				<b>(${success})</b> Asistencias, <b>(${error})</b> Errores
			`;
			document.querySelector('#reload').style.display = 'block';
		};
		xhr.onerror = function () {
			console.error('Error de conexión');
		};

		if (getAsistencia() === undefined) {
			alert('Por favor, marcar todas las asistencias.');
			break;
		} else {
			const data_send = `
                createAsistencia=true&
                alumno_id=${parseInt(alumnoId)}&
                fecha_asistencia=${year.value}&
                estado=${getAsistencia().estado}&
                descripcion=${getAsistencia().motivo ?? ''}&
                curso_id=${parseInt(id_curso.value)}
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
		}
	}
};

const setNewData = (data) => {
	const tbody = document.querySelector('tbody');
	tbody.innerHTML = '';

	if (data[0].length <= 0) {
		tbody.innerHTML += `
        <tr class="asistencias">
            <td align="center" style="padding: 10px 0" colspan=4>No se encontraron asistencias</td>
        </tr>
        `;
	} else {
		const combinedData = {};

		data[0].forEach((nota) => {
			const alumnoId = nota.alumno_id;
			if (!combinedData[alumnoId]) {
				combinedData[alumnoId] = {
					notas: [],
					asistencias: [],
				};
			}
			combinedData[alumnoId].notas.push(nota);
		});

		data[1].forEach((asistencia) => {
			const alumnoId = asistencia.alumno_id;
			if (!combinedData[alumnoId]) {
				combinedData[alumnoId] = {
					notas: [],
					asistencias: [],
				};
			}
			combinedData[alumnoId].asistencias.push(asistencia);
		});

		Object.keys(combinedData).forEach((alumnoId) => {
			const { notas, asistencias } = combinedData[alumnoId];

			notas.forEach((nota) => {
				const asist = asistencias.find((a) => a.alumno_id === nota.alumno_id);
				console.log(data);
				tbody.innerHTML += `
                    <tr class="asistencias">
                        <td hidden>
                            <input type="number" value="${nota.alumno_id}">
                        </td>
                        <td id="nombres_apellidos">${
													nota.nombres_apellidos
												}</td>
                        <td class="btn">
                            <input onclick="showJustify(this)" ${
															asist && asist.estado === 'Presente'
																? 'checked'
																: ''
														} class="asistencia presente ${
					nota.alumno_id
				}" type='radio' name="asistencia_${nota.alumno_id}">
                        </td>
                        <td class="btn">
                            <input onclick="showJustify(this)" ${
															asist && asist.estado === 'Faltó' ? 'checked' : ''
														} class="asistencia falta ${
					nota.alumno_id
				}" type='radio' name="asistencia_${nota.alumno_id}">
                        </td>
                        <td class="btn">
                            <input onclick="showJustify(this)" ${
															asist && asist.estado === 'Justificado'
																? 'checked'
																: ''
														} class="asistencia justificado ${
					nota.alumno_id
				}" type='radio' name="asistencia_${nota.alumno_id}">
                        </td>
                    </tr>
                    <tr id="desc_justificado_${
											nota.alumno_id
										}" class="desc_justificacion" ${
					asist && asist.estado === 'Justificado' ? '' : 'hidden'
				}>
                        <td colspan="4">
                            <label>Justificación:</label>
                            <input class="motivo" type="text" value="${
															asist?.descripcion ?? ''
														}">
                        </td>
                    </tr>`;
			});
		});
	}
};

const cargarData = async (fecha) => {
	loader.style.display = 'flex';
	const xhr = new XMLHttpRequest();
	xhr.open('POST', `/controllers/actions/docente/actionsAsistencias.php`);
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xhr.onload = function () {
		if (xhr.status === 200) {
			setNewData(JSON.parse(xhr.response));
		} else {
			console.error(xhr.response);
		}
		loader.style.display = 'none';
	};
	xhr.onerror = function () {
		console.error('Error de conexión');
	};
	const data = `getAsistencia=true&fecha=${fecha}&curso_id=${parseInt(
		id_curso.value
	)}`;
	xhr.send(data);
};

function obtenerFecha() {
	const fecha = new Date();
	const year = fecha.getFullYear();
	const month = String(fecha.getMonth() + 1).padStart(2, '0');
	const day = String(fecha.getDate()).padStart(2, '0');

	return `${year}-${month}-${day}`;
}

cargarData(obtenerFecha());
