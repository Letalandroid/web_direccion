<?php

$apoderado = true;
$docente = false;
$director = false;
$url = $_SERVER['REQUEST_URI'];

if ($apoderado) {
    $path = __DIR__ . '/views';
    $profile = explode('/', $url)[1];
    $reg = explode('/', $url)[2];
    $url_now =  $path . "/$profile/pages/$reg" . '.php';

    if (file_exists($url_now)) {

        require $url_now;

    } else {
        $index = $path . "/$profile/pages/home.php";

        if (file_exists($index)) {
            require $index;
        } else {
            $not_found = $path . "/404/404.php";

            if (file_exists($not_found)) {
                require $not_found;
            }
        }
    }
}
