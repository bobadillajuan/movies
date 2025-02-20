<?php

session_start();
$ruta = '../css';
require_once("../html/encabezado.html");
if (!empty($_SESSION['usuario'])) { 

    $id = $_GET['id'];
    $tiempo = time() + 60 * 24 * 60 * 60;

    
    if (!empty($_COOKIE[$_SESSION['usuario']]) && isset($_COOKIE[$_SESSION['usuario']])) {

        $favoritas = $_COOKIE[$_SESSION['usuario']];
        $favoritasArreglo = explode(',', $favoritas);
        var_dump($favoritasArreglo);

        foreach ($favoritasArreglo as $clave => $valor){
            if ($valor == $id) {
                $id = 0;
                break;
            }
        }

        if ($id != 0) {
        echo '<p class="pAviso">Guardado Exitoso</p>';
        setcookie($_SESSION['usuario'], $_COOKIE[$_SESSION['usuario']].','.$id, $tiempo, '/');
        }else{
        echo '<p class="pAviso">Pelicula ya guardada!</p>';
        header('refresh:2; url=pelicula_listado.php');
        }

        
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