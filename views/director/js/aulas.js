const btnAdd = document.querySelector('#btnAdd');
const iconShow = document.querySelector('.fa-plus');
const btnShow = document.querySelector('#btn_show_add');
const addCourseContainer = document.querySelector('.add__course');
const containerNotas = document.querySelector('.container__notas');
const reload = document.querySelector('.reload');

let active_course = false;

const mostrar = () => {

    if (!active_course) {
        iconShow.style.transform = 'rotate(45deg)';
        addCourseContainer.style.height = '80px';
        containerNotas.style.height = 'calc(100vh - 72.31px - 36.78px - 60px - 80px)';
        active_course = true;
    } else {
        iconShow.style.transform = 'rotate(0)';
        addCourseContainer.style.height = 0;
        containerNotas.style.height = 'calc(100vh - 72.31px - 36.78px - 60px)';
        active_course = false;
    }

}

btnAdd.addEventListener('click', () => {


    const courseName = document.querySelector('#new_course').value;

    if (courseName.length <= 0) {
        alert('El curso no puede estar vacío');
    } else {
        const xhr = new XMLHttpRequest();
				xhr.open('POST', '/controllers/actions/director/actionsCursos.php');
				xhr.setRequestHeader(
					'Content-Type',
					'application/x-www-form-urlencoded'
				);
				xhr.onload = function () {
					if (xhr.status === 200) {
						console.log(xhr.response);
						reload.style.display = 'block';
					} else {
						console.log(JSON.parse(xhr.response));
                        reload.innerHTML = 'Error en la ejecución. <b>Error code: [500]<b>';
                        reload.id = 'error';
						reload.style.display = 'block';
					}
				};
				xhr.onerror = function () {
					console.error('Error de conexión');
				};
				xhr.send(`createCurso=true&nombre=${courseName}`);
    }
});

// para que solo permita letras A B C 
function soloLetras(event){
    var letra = event.keyCode;
    
    if(!isNaN(event.target.value)){
        return true;
        

    }else{
        alert('Solo de permiten Letras');
        return false;
    }
}