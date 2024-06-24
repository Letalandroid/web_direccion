<?php

use Letalandroid\controllers\Docente;

require_once __DIR__ . '/../../../controllers/Docente.php';

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] != 'Director') {
    header('Location: /');
    exit();
}

$docentes = Docente::getAllMin();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/views/director/css/header.css" />
    <link rel="stylesheet" href="/views/director/css/administracion.css">
    <link rel="shortcut icon" href="/views/director/assets/img/logo_transparent.png" type="image/x-icon" />
    <script defer src="/views/director/js/header.js"></script>
    <script defer>
        document.addEventListener("DOMContentLoaded", () => {
            closed_menu();
        });
    </script>
    <script src="https://kit.fontawesome.com/8b1c082df7.js" crossorigin="anonymous"></script>
    <title>I.E.P Los Clavelitos de SJT - Piura | Alumnos</title>
</head>

<body>
    <?php require_once __DIR__ . '/../components/header.php' ?>
    <main>
        <?php show_nav('Docente'); ?>
        <div class="container">
    <h1>ADMINISTRACION</h1>
    <div class="search-bar">
      <label for="dni">DNI:</label>
      <input type="text" id="dni" name="dni">
      <button class="btn search">Buscar</button>
      <button class="btn clear">Limpiar</button>
    </div>
    <table>
      <thead>
        <tr>
          <th>DNI</th>
          <th>NOMBRE Y APELLIDOS</th>
          <th>GENERO</th>
          <th>FECHA DE NACIMIENTO</th>
          <th>Editar</th>
          <th>Eliminar</th>
        </tr>
      </thead>
      <tbody>
        <?php for ($i = 0; $i < 4; $i++): ?>
        <tr>
          <td>77233993</td>
          <td>JOSE GONZALES SIANCAS</td>
          <td>Masculino</td>
          <td>18/12/2003</td>
          <td><button class="btn edit"></button></td>
          <td><button class="btn delete"></button></td>
        </tr>
        <?php endfor; ?>
      </tbody>
    </table>
  </div>
</body>
</body>

</html>