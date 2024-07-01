<?php
use Letalandroid\controllers\Apoderado;

require_once __DIR__ . '/../../../controllers/Apoderado.php';

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] != 'Director') {
    header('Location: /');
    exit();
}

$apoderados_con = Apoderado::getAllCon();
$apoderados_reverse = Apoderado::getAllReverse();
$apoderados_sin = Apoderado::getAllSinAlumn();
$apoderados = Apoderado::getAll();
$apoderados_hijos = Apoderado::getAllhijos();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/views/director/css/header.css" />
    <link rel="stylesheet" href="/views/director/css/apoderado.css">
    <link rel="shortcut icon" href="/views/director/assets/img/logo_transparent.png" type="image/x-icon" />
    <script defer src="/views/director/js/header.js"></script>
    <script defer>
        document.addEventListener("DOMContentLoaded", () => {
            closed_menu();
        });
    </script>
    <script src="https://kit.fontawesome.com/8b1c082df7.js" crossorigin="anonymous"></script>
    <title>I.E.P Los Clavelitos de SJT - Piura | Apoderados</title>
</head>

<body>
    <?php require_once __DIR__ . '/../components/header.php' ?>
    <main>
        <?php show_nav('Apoderados'); ?>
        <div class="container__section">
            <div id="reload">
                <p>Parece que hay nuevos cambios, se sugiere <button onclick="location.reload();">recargar</button></p>
            </div>
            <div class="search__apoderado">
                <label>Buscar:</label>
                <div>
                    <input id="search_apoderado" type="text" placeholder="<?= $apoderados_reverse[0]['nombres_apellidos'] ?>" maxlength="100">
                    <button onclick="buscarApoderado()">Buscar</button>
                    <button onclick="showAdd()">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="create__apoderado">
                <h3>Agregar apoderado</h3>
                <div class="container__data_apoderado">
                    <div class="left">
                        <div>
                            <label>Nombres: </label>
                            <input id="nombres" class="send_data" type="text" onkeydown="return soloLetras(event)" maxlength="50" required>
                            <script src="/views/director/js/home.js"></script>
                        </div>
                        <div>
                            <label>Apellidos: </label>
                            <input id="apellidos" class="send_data" type="text" onkeydown="return soloLetras(event)" maxlength="50" required>
                            <script src="/views/director/js/home.js"></script>
                        </div>
                        <div>
                            <label>DNI: </label>
                            <input id="dni" class="send_data" type="text" onkeydown="return soloNumeros(event)" minlength="8" maxlength="8" required>
                            <script src="/views/director/js/home.js"></script>
                        </div>
                        <div>
                            <label>Género: </label>
                            <select id="genero">
                                <option value="Masculino">Masculino</option>
                                <option value="Femenino">Femenino</option>
                            </select>
                        </div>
                    </div>
                    <div class="right">
                        <div>
                            <label>Nacionalidad:</label>
                            <input id="nacionalidad" class="send_data" type="text" onkeydown="return soloLetras(event)" maxlength="20" required>
                            <script src="/views/director/js/home.js"></script>
                        </div>
                        <div>
                            <label>Fecha Nacimiento: </label>
                            <input id="fecha_nacimiento" class="send_data" type="date" required>
                        </div>
                        <div>
                            <label>Telefono: </label>
                            <input id="telefono" class="send_data" type="text" onkeydown="return soloNumeros(event)" minlength="9" maxlength="9" required>
                            <script src="/views/director/js/home.js"></script>
                        </div>
                        <div>
                            <label>Correo: </label>
                            <input id="correo" class="send_data" type="text" maxlength="100" required>
                        </div>
                    </div>
                </div>
                <div class="botones">
                <button onclick="addApoderado()">Agregar</button>
                </div>
            </div>

            <div class="container_Boton">
    <button onclick="window.open('/views/pdf/pages/director/imprimirApoderado.php', '_blank')">
        <i class="fas fa-file-pdf"></i> Generar PDF</button>
</div>

            <?php if (!empty($apoderados_sin)) { ?>
                <div class="apo_null_container">
                    <h2>Apoderados sin hijos asignados</h2>
                    <table>
                        <thead>
                            <th>DNI</th>
                            <th>NOMBRES Y APODERDADO</th>
                            <th>GENERO</th>
                            <th>FECHA.NACIM</th>
                            <th>TELEF</th>
                            <th>CORREO</th>
                            <th>EDITAR</th>
                            <th>ELIMINAR</th>
                        </thead>
                        <tbody>
                            <?php foreach ($apoderados_sin as $apoderado) { ?>
                                <tr>
                                    <td><?= $apoderado['dni'] ?></td>
                                    <td><?= $apoderado['nombres_apellidos'] ?></td>
                                    <td><?= $apoderado['genero'] ?></td>
                                    <?php $d_apoderado = explode('-', date("d-m-Y", strtotime($apoderado['fecha_nacimiento']))); ?>
                                    <td><?= "$d_apoderado[0] de $d_apoderado[1] del $d_apoderado[2]" ?></td>
                                    <td><?= $apoderado['telefono'] ?></td>
                                    <td><?= $apoderado['correo'] ?></td>
                                    <td><a class="edit-button" href='/views/director/pages/editarapoderado.php?id=<?= $apoderado['apoderado_id'] ?>'"><i class="fa fa-edit"></a></td>                         
                                    <td><button class="delete-button" onclick="eliminarApoderado(<?= htmlspecialchars($apoderado['apoderado_id']) ?>)"><i class="fa fa-trash"></i></button></td>

                                    </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    
                </div>
            <?php } ?>

            <table id="apoderadosTable">
                <thead>
                            <th>DNI</th>
                            <th>NOMBRES Y APELLIDOS</th>
                            <th>GENERO</th>
                            <th>FECHA.NACIM</th>
                            <th>TELEF</th>
                            <th>CORREO</th>
                            <th>ALUM</th>
                            <th>EDITAR</th>
                            <th>ELIMINAR</th>
                </thead>
                <tbody>
                    <?php foreach ($apoderados_con as $apoderado) { ?>
                        <tr>
                            <td><?= $apoderado['dni'] ?></td>
                            <td><?= $apoderado['nombres_apellidos'] ?></td>
                            <td><?= $apoderado['genero'] ?></td>
                            <?php $d_apoderado = explode('-', date("d-m-Y", strtotime($apoderado['fecha_nacimiento']))); ?>
                            <td><?= "$d_apoderado[0] de $d_apoderado[1] del $d_apoderado[2]" ?></td>
                            <td><?= $apoderado['telefono'] ?></td>
                            <td><?= $apoderado['correo'] ?></td>
                            <td><button class="ver-button apo_<?=$apoderado['apoderado_id'] ?> " onclick="getHijos(<?=$apoderado['apoderado_id'] ?>)" ><i class="fa fa-eye icon"></button></td>
                            <td><a class="edit-button"  href='/views/director/pages/editarapoderado.php?id=<?= $apoderado['apoderado_id'] ?>'"><i class="fa fa-edit"></a></td>                         
                            <td><a class="delete-button" onclick="eliminarApoderado(<?= $apoderado['apoderado_id'] ?>)"><i class="fa fa-trash"></i></a></td>                                               
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            
        </div>
        </div>
        
	<div class="citas__container">
		<div class="citas__modal">
			<h3>Hijos</h3>
			<p></p>
			<div class="closed_cita">
				<button onclick="closed_cita()">Cerrar</button>
			</div>
		</div>
	</div>
    </main>
    <script>
        let show = false;
        const apoderadosAll = <?= json_encode($apoderados_hijos ?? []) ?>;

        const getHijos = (apoderado_id) => {
            let hijos = [];
            apoderadosAll.forEach((a)=>{
                if(a.apoderado_id==apoderado_id){
                    hijos.push(a);
                }
                
        })
        setCita(hijos);
        }
///ALUMNOS
        
		const citas_container = document.querySelector('#citas');
		const citas__container = document.querySelector('.citas__container');

		

		const setCita = (desc) => {
            

			const desc_json = JSON.parse(JSON.stringify(desc));

			if (typeof desc_json === 'object') {
				let ul = document.createElement('ul');
				desc_json.forEach((item) => {
					let li = document.createElement('li');
					li.textContent = item.nombres_apellidos;
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
        
///
        const buscarApoderado = () => {
            const apoderadoName = document.getElementById('search_apoderado').value.toLowerCase();
            const apoderados = <?= json_encode($apoderados_con ?? []) ?>;
            const matchingApoderados = apoderados.filter(apoderado => 
            apoderado.nombres_apellidos.toLowerCase().includes(apoderadoName.toLowerCase()) || 
            apoderado.dni.includes(apoderadoName)
            );

            const tableBody = document.getElementById('apoderadosTable').getElementsByTagName('tbody')[0];
            tableBody.innerHTML = "";

            if (matchingApoderados.length > 0) {
                matchingApoderados.forEach(apoderado => {
                    const row = tableBody.insertRow();
                    row.innerHTML = `
                        <td>${apoderado.dni}</td>
                        <td>${apoderado.nombres_apellidos}</td>
                        <td>${apoderado.genero}</td>
                        <td>${apoderado.fecha_nacimiento}</td>
                        <td>${apoderado.telefono}</td>
                        <td>${apoderado.correo}</td>

                    `;
                });
            } else {
                const row = tableBody.insertRow();
                const cell = row.insertCell();
                cell.colSpan = 5;
                cell.textContent = "No se encontraron resultados";
            }
        }

        const showAdd = () => {
            const icon = document.querySelector('.fa-plus');
            const create_apoderado = document.querySelector('.create__apoderado');

            if (!show) {
                create_apoderado.style.height = 'auto';
                icon.style.transform = 'rotate(45deg)';
                show = true;
            } else {
                create_apoderado.style.height = 0
                icon.style.transform = 'rotate(0)';
                show = false;
            }
        }

        const addApoderado = async () => {
            let isEmpty = false;

            document.querySelectorAll('.send_data').forEach((data) => {
                if (data.value.length <= 0 || data.value.startsWith(' ')) {
                    isEmpty = true;
                    return;
                }
            });

            if (!isEmpty) {
                const nombres = document.querySelector('#nombres').value;
                const apellidos = document.querySelector('#apellidos').value;
                const dni = document.querySelector('#dni').value;
                const genero = document.querySelector('#genero').value;
                const nacionalidad = document.querySelector('#nacionalidad').value;
                const fecha_nacimiento = document.querySelector('#fecha_nacimiento').value;
                const telefono = document.querySelector('#telefono').value;
                const correo = document.querySelector('#correo').value;

                const xhr = new XMLHttpRequest();
                xhr.open('POST', '/controllers/actions/director/actionsApoderado.php');
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        console.log(xhr.response);
                       // document.querySelector('#reload').style.display = 'block';
                        location.reload();
                    } else {
                        console.log(xhr.response);
                    }
                };
                xhr.onerror = function() {
                    console.error('Error de conexión');
                };
                xhr.send(`createApoderado=true&nombres=${nombres}&apellidos=${apellidos}&dni=${dni}&genero=${genero}&fecha_nacimiento=${fecha_nacimiento}&nacionalidad=${nacionalidad}&telefono=${telefono}&correo=${correo}`);
            } else {
                alert('Existen uno o más campos vacíos.');
            }
        }
        const limpiarBusqueda = () => {
            document.getElementById('search_apoderado').value = '';
            const rows = document.querySelectorAll('#apoderadosTable tbody tr');
            rows.forEach(row => {
                row.style.display = '';
            });
        }

        const eliminarApoderado = (apoderado_id) => {
    console.log(`Intentando eliminar el apoderado con ID: ${apoderado_id}`); 
    if (confirm('¿Estás seguro de que deseas eliminar este apoderado?')) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/controllers/actions/director/actionsApoderado.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            console.log('Estado del servidor: ', xhr.status); // Registro de depuración
            console.log('Respuesta del servidor: ', xhr.response); // Registro de depuración
            if (xhr.status === 200) {
                alert('Apoderado eliminado exitosamente');
                location.reload(); // Recargar la página para ver los cambios
            } else {
                alert('Error al eliminar el apoderado');
                console.error(xhr.response);
            }
        };
        xhr.onerror = function() {
            alert('Error de conexión');
            console.error('Error de conexión');
        };
        xhr.send(`deleteApoderado=true&apoderado_id=${apoderado_id}`);
    }
}




    </script>
</body>

</html>
