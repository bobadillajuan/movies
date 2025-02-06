<?php
    session_start();
    $ruta = '../css';
    require_once("../html/encabezado.html");
    if (!empty($_SESSION['usuario'])) {
        echo '<h2>Está saliendo de la sesión</h2>';
        session_destroy();
        header('refresh:4; ../index.php');
    } else {
        echo '<h2>No inició sesión</h2>';
        header('refresh:3; ../index.php');
    }
    require_once ("../html/pie.html");
?>