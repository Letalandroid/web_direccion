<?php

$apoderado = true;
$docente = false;
$director = false;

$url = $_SERVER['REQUEST_URI'];
$path = __DIR__ . '/views';
$route = explode('/', $url);
$profile = $route[1];
$reg = $route[2] ?? '';
$url_now =  $path . "/$profile/pages/$reg" . '.php';

if ($apoderado) {

    if (file_exists($url_now)) {

        require $url_now;

    } else {
        $index = $path . "/$profile/pages/home.php";

        if (file_exists($index) && empty($reg)) {
            require $index;
        } else {
            $not_found = $path . "/404/404.php";

            if (file_exists($not_found)) {
                require $not_found;
            }
        }
    }
}
