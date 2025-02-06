<?php
    $ruta = 'css';
    require_once("html/encabezado.html");
?>

<main>


    <!--  -->
    <form action="php/loguear.php" method="post">
    <fieldset class="formulario">
        <h4>Iniciar Sesión</h4>
    <label for="usu">
        <input type="text" name="usua" id="usu"  placeholder="Usuario">
    </label>
    <label for="con"> 
        <input type="password" name="cont" id="con" placeholder="Contraseña">
    </label>
    <input type="submit" id="enviar" value="Iniciar Sesión">
    </fieldset>
    </form>

</main>


<?php
    require_once("html/pie.html");
?>