const notas_alumno = [
	{
		id: 1,
		curso: 'Comunicacion',
		notas_bimestres: [
			{
				practica: 14,
				participacion: 13,
				examen: 9,
			},
			{
				practica: 14,
				participacion: 13,
				examen: 9,
			},
			{
				practica: 14,
				participacion: 13,
				examen: 9,
			},
			{
				practica: 14,
				participacion: 13,
				examen: 9,
			}
		],
	},
	{
		id: 2,
		curso: 'Matemática',
		notas_bimestres: [
			{
				practica: 18,
				participacion: 18.5,
				examen: 19,
			},
			{
				practica: 18,
				participacion: 18.5,
				examen: 19,
			},
			{
				practica: 18,
				participacion: 18.5,
				examen: 19,
			},
			{
				practica: 18,
				participacion: 18.5,
				examen: 19,
			}
		],
	},
];

const container_notes = document.querySelector('.container__notas');
let contenido = '';

notas_alumno.forEach((notas, index) => {

    const nPractica = notas.notas_bimestres[index].practica;
    const nParticipacion = notas.notas_bimestres[index].participacion;
    const nExamen = notas.notas_bimestres[index].examen;
    let promedio = (nPractica + nParticipacion + nExamen) / 4;
    let color;

    if (promedio <= 20 && promedio >= 18) {
        promedio = 'AD';
        color = '#2fbf65';
    } else if (promedio <= 17 && promedio >= 15) {
        promedio = 'A';
        color = '#39E379; color: #000';
    } else if (promedio <= 14 && promedio >= 11) {
        promedio = 'B';
        color = '#ff8d00';
    } else if (promedio <= 10 && promedio >= 0) {
        promedio = 'C';
        color = '#f00';
    }

    let notas_bimestre = '';

    notas.notas_bimestres.forEach((nBim, index) => {
        notas_bimestre += `
            <div>
                <h3>${index + 1} Bimestre:</h3>
                <span>Participación: ${nBim.participacion}</span>
                <span>Práctica: ${nBim.practica}</span>
                <span>Examen Bimestral: ${nBim.examen}</span>
            </div>
        `;
    });

    contenido += `
        <div class="section__notas sec_${notas.id}">
            <div class='notas__contain'>
                <div>
                    <i class="fas fa-book-open"></i>
                    <h3>${notas.curso}</h3>
                </div>
                <div>
                    <p>Promedio:</p>
                    <span style='background-color: ${color};'>${promedio}</span>
                </div>
            </div>
            <div class='notas__bim n__${notas.id}'>
                ${notas_bimestre}
            </div>
            <button id='btn_${notas.id}' onclick='btnActivate(${notas.id})'><i class="fas fa-chevron-right"></i></button>
        </div>`;
})

container_notes.innerHTML += contenido;

const btnActivate = (id) => {

	const btnActivate = document.querySelector(`#btn_${id}`);
	const container_activate = document.querySelector(`.n__${id}`);
	const section_notes = document.querySelector(`.sec_${id}`);

	container_activate.classList.toggle('activate');
	btnActivate.classList.toggle('activate_btn');
	section_notes.classList.toggle('sparcing');

}