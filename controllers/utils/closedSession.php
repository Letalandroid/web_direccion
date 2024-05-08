<?php

function closedSession()
{
    session_start();
    session_destroy();
    header('Location: /');
}

if (isset($_GET['closed'])) {
    closedSession();
}