<?php
    session_start();
    $ruta = '../css';
    require_once("../html/encabezado.html");
    require_once('menu.php');

if (!empty($_SESSION['usuario'])) { 
    ?>

    <form action="enviar_correo.php" method="post">
    <fieldset class="formularioCorreo">

        <h4>Enviar correo</h4>

    <label for="mot">Motivo:
        <select name="motivo" id="mot">
            <option value="Sugerencia" selected>Sugerencia</option>
            <option value="Reclamo">Reclamo</option>
        </select>
    </label>

    <label for="men">Mensaje: 
        <textarea name="mensaje" id="men" cols="30" rows="10"></textarea>
    </label>
    <input type="submit" id="enviar" value="Enviar">

    </fieldset>
    </form>


    <?php
} else {
    echo '<h2>No inició sesión</h2>';
    header('refresh:3; ../index.php');
}

    require_once("../html/pie.html");
?>