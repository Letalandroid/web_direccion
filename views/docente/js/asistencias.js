const asistencias = document.querySelectorAll('.asistencia');
const nombres_apellidos = document.querySelector('#nombres_apellidos');
const id_curso = document.querySelector('#id_curso').value;
const year = document.querySelector('#year');

var fechaActual = new Date();

// Formatear la fecha en el formato YYYY-MM-DD
var formatoFecha =
	fechaActual.getFullYear() +
	'-' +
	('0' + (fechaActual.getMonth() + 1)).slice(-2) +
	'-' +
	('0' + fechaActual.getDate()).slice(-2);

year.value = formatoFecha;

asistencias.forEach((a) => {
	a.addEventListener('click', () => {
		const desc_justificado = document.querySelector(
			`#desc_justificado_${a.classList[2]}`
		);

		if (a.classList.contains('justificado')) {
			desc_justificado.hidden = false;
		} else {
			desc_justificado.hidden = true;
		}
	});
});

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

const enviarAsistencia = () => {
	const asistenciasRows = document.querySelectorAll('tr.asistencias');
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

		const xhr = new XMLHttpRequest();
		xhr.open('POST', '/controllers/actions/docente/actionsAsistencias.php');
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.onload = function () {
			if (xhr.status === 200) {
				console.log(xhr.response);
				document.querySelector('#reload').style.display = 'block';
			} else {
				console.log(xhr.response);
			}
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
                curso_id=${parseInt(id_curso)}
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

	if (data.length <= 0) {
		tbody.innerHTML += `
        <tr class="asistencias">
            <td align="center" style="padding: 10px 0" colspan=4>No se encontraron asistencias</td>
        </tr>
        `;
	} else {
		data.forEach((asist) => {
			tbody.innerHTML += `
        <tr class="asistencias">
            <td hidden>
                <input type="number" value="${asist.alumno_id}">
            </td>
            <td id="nombres_apellidos">${asist.nombres_apellidos}</td>
            <td class="btn">
                <input ${
									asist.estado == 'Presente' ? 'checked' : ''
								} class="asistencia presente ${
				asist.alumno_id
			}" type='radio' name="asistencia_${asist.alumno_id}">
            </td>
            <td class="btn">
                <input ${
									asist.estado == 'Faltó' ? 'checked' : ''
								} class="asistencia falta ${
				asist.alumno_id
			}" type='radio' name="asistencia_${asist.alumno_id}">
            </td>
            <td class="btn">
                <input ${
									asist.estado == 'Justificado' ? 'checked' : ''
								} class="asistencia justificado ${
				asist.alumno_id
			}" type='radio' name="asistencia_${asist.alumno_id}">
            </td>
        </tr>
        <tr id="desc_justificado_${
					asist.alumno_id
				}" class="desc_justificacion" hidden>
            <td colspan="4">
                <label>Justificación:</label>
                <input class="motivo" type="text">
            </td>
        </tr>`;
		});
	}
};

const cargarData = async (fecha) => {
	const xhr = new XMLHttpRequest();
	xhr.open('POST', `/controllers/actions/docente/actionsAsistencias.php`);
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xhr.onload = function () {
		if (xhr.status === 200) {
			setNewData(JSON.parse(xhr.response));
		} else {
			console.error(JSON.parse(xhr.response));
		}
	};
	xhr.onerror = function () {
		console.error('Error de conexión');
	};
	const data = `getAsistencia=true&fecha=${fecha}`;
	xhr.send(data);
};
