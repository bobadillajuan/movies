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

    <form action="pelicula_guardar.php" method="post" enctype="multipart/form-data">
    <fieldset class="formularioPelicula">
        <h4>Agregar Película</h4>
    <label for="tit">Título:
        <input type="text" name="titulo" id="tit"  placeholder="Ingrese el título">
    </label>
    <label for="dur">Duración: 
        <input type="number" name="duracion" id="dur" placeholder="Duración de la película">
    </label>
    <label for="gen">Género: 
        <select name="genero" id="gen">
            <option value="Comedia">Comedia</option>
            <option value="Accion">Accion</option>
            <option value="Terror">Terror</option>
            <option value="Ciencia Ficción">Ciencia Ficcion</option>
        </select>
    </label>
    <label for="fechEstreno">Fecha de Estreno: 
        <input type="date" name="fechaEstreno" id="fechEstreno">
    </label>
    <label for="port">Portada: 
        <input type="file" name="portada" id="port">
    </label>
    <input type="submit" id="enviar" value="Subir Película">
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