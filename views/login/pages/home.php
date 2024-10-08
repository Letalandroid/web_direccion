<?php

use Letalandroid\controllers\Usuarios;

require_once __DIR__ . '/../../../controllers/Usuarios.php';

$error = array(
    'status' => false,
    'message' => 'test'
);

if (isset($_POST['login'])) {

    $data = Usuarios::getAll();

    if (is_array($data) && !empty($data) && !isset($data['error'])) {
        $userFound = false;
        foreach ($data as $users) {
            if ($users['username'] == $_POST['username']) {
                $userFound = true;

                if (password_verify($_POST['password'], $users['password'])) {

                    session_start();
                    $_SESSION['username'] = $users['username'];
                    $_SESSION['user_id'] = $users['user_id'];
                    $_SESSION['rol'] = $users['rol'];

                    switch ($users['rol']) {
                        case 'Apoderado':
                            $_SESSION['apoderado_id'] = $users['apoderado_id'];
                            header('Location: /apoderado');
                            exit();

                        case 'Docente':
                            $_SESSION['docente_id'] = $users['docente_id'];
                            header('Location: /docente');
                            exit();

                        case 'Director':
                            $_SESSION['docente_id'] = $users['docente_id'];
                            header('Location: /director');
                            exit();

                        default:
                            header('Location: /');
                            exit();
                    }

                } else {
                    $error['status'] = true;
                    $error['message'] = 'Contraseña incorrecta';
                    break;
                }

            }
        }

        if (!$userFound) {
            $error['status'] = true;
            $error['message'] = 'Usuario no encontrado';
        }
    } else {
        $error['status'] = true;
        $error['message'] = 'Error al obtener datos de usuario';
    }

} else {
    session_start();
    session_destroy();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <title>I.E.P Los Clavelitos de SJT - Piura | Login</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="/views/login/css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="/views/apoderado/assets/img/logo_transparent.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
    <?php if ($error['status']) { ?>
        <div class="alert alert-danger alert-dismissible fade show m-2" role="alert">
            <strong>❌ Error:</strong> <?= $error['message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php } ?>
    <div class="frcontac">
    <h5 class="ds1"><B>CONTACTANOS</B></h5>   
    <div class="imgwsp">
        <img src="/views/login/assets/img/whatsappicon.png" alt="">
    </div> 
    <div class="contacto">
    <input type="submit" class="btn-grow-ellipse-contac" value="XXX XXX XXX">
    </div>
    </div>
    <form action="/login" method="post" class="fr1">
        <div class="img">
            <img src="/views/login/assets/img/icon.png" alt="">
        </div>
        <h4><b>I.E.P</h4>
        <h4 class="d1"><b>Los clavelitos de San Judas Tadeo</b></h4>

        <label for="username"><b>Usuario</b></label>
        <input required name="username" type="text" placeholder="0987654321" id="username">

        <label for="password"><b>Contraseña</b></label>
        <input required name="password" type="password" placeholder="*******************" id="password">
        <input hidden name="login" type="text" value="true">

        <input type="submit" class="btn-grow-ellipse" value="Iniciar sesión">
        <p><a href="">Olvide mi contraseña</a></p>
    </form>
    
    
</body>

</html>