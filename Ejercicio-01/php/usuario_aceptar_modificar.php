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

    // Controlamos ademas de que solo se pueda ingresar con un ID identificador del usuario al que modificar
    if($conexion && !empty($_POST['id'])){


    // Esto mueve la imagen y además la renombra. Pero no hace el control de si es que existe tal carpeta
    if(!empty($_FILES['foto']['size']))
    {
    $nombreFoto = $_FILES['foto']['name'];
    $ext = explode('.', $nombreFoto);
    $rutaOrigen = $_FILES['foto']['tmp_name'];
    $destino = '../img/usuarios/' . $_POST['usuario'] . '.' . $ext[1];              
    $resultado = move_uploaded_file($rutaOrigen, $destino);
    $foto_usuario = $_POST['usuario'] . '.' . $ext[1];
    }else{
        $foto_usuario = NULL;
    }


    
    // ESTE BUCLE SOLO FUNCIONA SI ES QUE EN EL FORMULARIO LOS NOBRES DE LOS INPUTS COINCIDEN CON LOS NOMBRE EN LA TABLA
    $consulta = 'UPDATE usuario SET '; 
    foreach ($_POST as $clave => $valor) {
        if (!empty($valor) && $clave != 'id') {
            $consulta .= $clave . '= \'' . $valor . '\', ';
        }
    }

    // control para foto
    if (!empty($_FILES['foto']['size'])) {
        $consulta .= 'foto=\'' . $foto_usuario . '\', ';  
    }


    // armado de consulta
    $id = $_POST['id'];
    $consulta .= 'WHERE id = ' . $id . ';';
    $consulta = str_replace(", WHERE", " WHERE", $consulta);
    $resultado = mysqli_query($conexion, $consulta);


        if ($resultado){
            echo '<p class="pAviso">Modificación exitosa</p>';
            header('refresh:3; url=usuario_listado.php');

        }else{
            echo '<p class="pAviso">No se pudo modificar</p>';
        }

    }else{
        echo '<p class="pAviso">No se realizó la modificación</p>';
    }

    desconectar($conexion);

    }else{
        echo '<p class="pAviso">Su usuario no tiene permiso para ingresar a esta página</p>';
        header('refresh:3; url=usuario_listado.php');
    }

} else {
    echo '<h2>No inició sesión</h2>';
    header('refresh:3; ../index.php');
}

?>



<?php
    require_once("../html/pie.html");
?>