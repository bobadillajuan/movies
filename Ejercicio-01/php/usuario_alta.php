<?php
    session_start();
    $ruta = '../css';
    require_once("../html/encabezado.html");
    require_once('menu.php');
?>

<?php

if (!empty($_SESSION['usuario'])) { 

    if ($_SESSION['tipo'] == 'Administrador') {
    
    ?>

    <form action="usuario_alta_ok.php" method="post" enctype="multipart/form-data">
    <fieldset class="formularioPelicula">
        <h4>Agregar Usuario</h4>

    <label for="usu">Usuario:
        <input type="text" name="usuario" id="usu"  placeholder="Ingrese el usuario nuevo" value="sha1">
    </label>

    <label for="cont">Contraseña: 
        <input type="password" name="contraseña" id="cont" value="1234">
    </label>

    <label for="mail">Correo:
        <input type="email" name="correo" id="mail"  placeholder="Ingrese el email" value="sha1@gmail.com">
    </label>

    <label for="fechAlta">Fecha de Alta: 
        <input type="date" name="fechaAlta" id="fechAlta" value="2021-10-02">
    </label>

    <label for="tip">Tipo de usuario: 
        <select name="tipo" id="tip">
            <option value="Administrador" selected>Administrador</option>
            <option value="Editor">Editor</option>
            <option value="Restringido">Restringido</option>
        </select>
    </label>
    
    <label for="fot">Foto: 
        <input type="file" name="foto" id="fot">
    </label>
    <input type="submit" id="enviar" value="Crear Usuario">
    </fieldset>
    </form>

    <?php

        
    }else{
        echo '<p class="pAviso">Su usuario no tiene permiso para ingresar a esta página</p>';
        header('refresh:3; url=pelicula_listado.php');
    }


} else {
    echo '<h2>No inició sesión</h2>';
    header('refresh:3; ../index.php');
}
?>


<?php
    require_once("../html/pie.html");
?>