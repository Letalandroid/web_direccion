const btn_left = document.querySelector('#btn_left');
const btn_right = document.querySelector('#btn_right');
const container_notas = document.querySelector('.container__notas');

btn_left.addEventListener('click', () => {
	container_notas.scrollLeft -= 150;
});

btn_right.addEventListener('click', () => {
	container_notas.scrollLeft += 150;
});

fetch('/controllers/alumnos.php')
	.then((response) => response.json())
	.then((data) => console.log(data))
	.catch((error) => console.error('Error:', error));
