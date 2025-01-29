<?php
    session_start();
    $ruta = '../css';
    require_once("../html/encabezado.html");
    require_once('conexion.php');
    require_once('menu.php');
    $conexion = conectar();
?>

<?php 
if (!empty($_SESSION['usuario'])) { 

    if ($_SESSION['tipo'] == 'Administrador' or $_SESSION['tipo'] == 'Editor') {
    
    if($conexion && !empty($_GET['id'])){

    $id = $_GET['id'];

    $consulta = 'SELECT * FROM pelicula WHERE id= "'. $id .'";'; 

    $resultado = mysqli_query($conexion, $consulta);

    desconectar($conexion);


    if (mysqli_num_rows($resultado) > 0){

            $fila = mysqli_fetch_array($resultado);

?>
    <article class="modificarArticle">
    <form action="aceptar_modificar.php" method="post" enctype="multipart/form-data">
    <fieldset class="formularioPelicula">
        <h4>Modificar Película</h4>
    <label for="tit">Título:
        <input type="text" name="titulo" id="tit"  placeholder="Ingrese el título" value="<?php echo $fila['titulo'];?>">
    </label>
    <label for="dur">Duración: 
        <input type="number" name="duracion" id="dur" placeholder="Duración de la película" value="<?php echo $fila['duracion'];?>">
    </label>
    <label for="gen">Género: 
        <select name="genero" id="gen">
            <!-- ¿Esto se hace así? no se me ocurría nada más jaja -->
            <option value="Comedia" <?php if($fila['genero']=='Comedia'){echo 'selected';}?>>Comedia</option>
            <option value="Accion" <?php if($fila['genero']=='Accion'){echo 'selected';}?>>Accion</option>
            <option value="Terror" <?php if($fila['genero']=='Terror'){echo 'selected';}?>>Terror</option>
            <option value="Ciencia Ficción" <?php if($fila['genero']=='Ciencia Ficción'){echo 'selected';}?>>Ciencia Ficción</option>
        </select>
    </label>
    <label for="fechEstreno">Fecha de Estreno: 
        <input type="date" name="fecha_estreno" id="fechEstreno" value="<?php echo $fila['fecha_estreno'];?>">
    </label>
    <label for="port">Portada: 
        <input type="file" name="foto_portada" id="port">
    </label>
    <input type="hidden" value="<?php echo $id ?>" name="id">
    <input type="submit" id="enviar" value="Modificar">
    </fieldset>
    </form>

    <a href="pelicula_listado.php" class="botonModificarCancelar">Cancelar</a>
    </article>
<?php
    }
    }else{
        echo '<p class="pAviso">No se puedo modificar, pruebe ingresando desde el listado de peliculas</p>';
        header('refresh:3; url=pelicula_listado.php');
    }

    }else{
        echo '<p class="pAviso">Su usuario no tiene permiso para ingresar a esta página</p>';
        header('refresh:3; url=pelicula_listado.php');
    }

} else {
    echo '<h2>No inició sesión</h2>';
    header('refresh:3; ../index.php');
}

require_once("../html/pie.html");
?>