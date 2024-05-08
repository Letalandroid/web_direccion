const btns_event = document.querySelectorAll('.event');
const container_event = document.querySelector('#container_event');

const eventos = [
	{
		dia: 18,
		descripcion: '📝Evaluación: S2_Frameworks de CSS',
	},
	{
		dia: 30,
		descripcion: '📝Evaluación: S3_Orientado a objetos',
	},
];

btns_event.forEach((btn) => {
	let active = false;

	btn.addEventListener('click', () => {
		if (!active) {
            btn.style.color = '#fff';
            btn.style.backgroundColor = 'var(--red)';
			container_event.innerHTML += `
            <div class='element__container e_${btn.innerHTML}'>
                <h3>Evento (${btn.innerHTML}/04):</h3>
                <p>${eventos.find((evento) => evento.dia == btn.innerHTML)?.descripcion}</p>
            </div>`;

			active = true;

		} else {
            btn.style.color = '#000';
            btn.style.backgroundColor = '#ffccca';
            document.querySelector(`.e_${btn.innerHTML}`).remove();
			active = false;
        }
	});
});
