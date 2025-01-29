<?php

session_start();
$ruta = '../css';
require_once("../html/encabezado.html");
if (!empty($_SESSION['usuario'])) { 

    $id = $_GET['id'];
    $tiempo = time() + 60 * 24 * 60 * 60;

    
    if (!empty($_COOKIE[$_SESSION['usuario']]) && isset($_COOKIE[$_SESSION['usuario']])) {
        //Aqui concateno
        setcookie($_SESSION['usuario'], $_COOKIE[$_SESSION['usuario']].','.$id, $tiempo, '/');
        echo '<p class="pAviso">Guardado Exitoso</p>';
        
    }else{
        setcookie($_SESSION['usuario'], $id, $tiempo, '/');
        echo '<p class="pAviso">Guardado Exitoso</p>';
    }

    header('refresh:2; url=pelicula_listado.php');

} else {
    echo '<h2>No inició sesión</h2>';
    header('refresh:3; ../index.php');
}


?>

<?php
    require_once("../html/pie.html");
?>