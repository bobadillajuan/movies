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

    $consulta = 'SELECT * FROM usuario WHERE id= "'. $id .'";'; 

    $resultado = mysqli_query($conexion, $consulta);

    desconectar($conexion);


    if (mysqli_num_rows($resultado) > 0){

            $fila = mysqli_fetch_array($resultado);

?>
    <article class="modificarArticle">
    <form action="usuario_aceptar_modificar.php" method="post" enctype="multipart/form-data">
    <fieldset class="formularioPelicula">
        <h4>Modificar usuario</h4>

    <label for="usu">Usuario:
        <input type="text" name="usuario" id="usu"  placeholder="Ingrese el usuario nuevo" value="<?php echo $fila['usuario']?>">
    </label>

    <label for="cont">Contraseña: 
        <input type="password" name="password" id="cont">
    </label>

    <label for="corre">Correo:
        <input type="email" name="mail" id="corre"  placeholder="Ingrese el email" value="<?php echo $fila['mail']?>">
    </label>

    <label for="fechAlta">Fecha de Alta: 
        <input type="date" name="fecha_alta" id="fechAlta" value="<?php echo $fila['fecha_alta']?>">
    </label>

    <label for="tip">Tipo de usuario: 
        <select name="tipo" id="tip">
            <option value="Administrador" <?php if($fila['tipo']=='Administrador'){echo 'selected';}?>>Administrador</option>
            <option value="Editor" <?php if($fila['tipo']=='Editor'){echo 'selected';}?>>Editor</option>
            <option value="Restringido" <?php if($fila['tipo']=='Restringido'){echo 'selected';}?>>Restringido</option>
        </select>
    </label>


    <label for="fot">Foto: 
        <input type="file" name="foto" id="fot">
    </label>

    <input type="hidden" value="<?php echo $id ?>" name="id">
    <input type="submit" id="enviar" value="Modificar">
    </fieldset>
    </form>

    <a href="usuario_listado.php" class="botonModificarCancelar">Cancelar</a>
    </article>
<?php
    }
    }else{
        echo '<p class="pAviso">No se puedo modificar, pruebe ingresando desde el listado de usuarios</p>';
        header('refresh:3; url=usuario_listado.php');
    }

    }else{
        echo '<p class="pAviso">Su usuario no tiene permiso para ingresar a esta página</p>';
        header('refresh:3; url=usuario_listado.php');
    }

} else {
    echo '<h2>No inició sesión</h2>';
    header('refresh:3; ../index.php');
}

require_once("../html/pie.html");
?>