<?php
    session_start();
    $ruta = '../css';
    require_once("../html/encabezado.html");
    require_once('menu.php');

if (!empty($_SESSION['usuario'])) { 

    if (!empty($_POST['mensaje']) && !empty($_POST['motivo'])) {
        //Estructura para mandar mails
        $asunto = $_POST['motivo'] . '-' . $_SESSION['usuario'];
        $mensaje = $_POST['mensaje'];
        $correoOrigen = $_SESSION['mail'];
        $correoDestino = 'bobadillajuanunt@gmail.com';
        $cabecera = 'From:' . $correoOrigen . "\r\n" . 'Reply-To:' . $correoOrigen;
        $resultado = mail($correoDestino, $asunto, $mensaje, $cabecera);

        if ($resultado) {
            echo '<p class="pAviso">Envío exitoso!</p>';
            header('refresh:2; url=contactenos.php');
        }else{
            echo '<p class="pAviso">No se pudo envíar!</p>';
            header('refresh:2; url=contactenos.php');
        }


    }else{
        echo '<p class="pAviso">Faltan datos!</p>';
    }

} else {
    echo '<h2>No inició sesión</h2>';
    header('refresh:3; ../index.php');
}

    require_once("../html/pie.html");
?>