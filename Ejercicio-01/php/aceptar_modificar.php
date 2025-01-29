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

    if($conexion && !empty($_POST['id'])){

    if(!empty($_FILES['foto_portada']['size']))
    {
    $nombrePortada = $_FILES['foto_portada']['name'];
    $ext = explode('.', $nombrePortada);
    $rutaOrigen = $_FILES['foto_portada']['tmp_name'];
    $destino = '../img/portadas/' . $_POST['titulo'] . '.' . $ext[1];              
    $resultado = move_uploaded_file($rutaOrigen, $destino);
    $foto_portada = $_POST['titulo'] . '.' . $ext[1];
    }else{
        $foto_portada = NULL;
    }


        
    $consulta = 'UPDATE pelicula SET '; 
    foreach ($_POST as $clave => $valor) {
        if (!empty($valor) && $clave != 'id') {
            $consulta .= $clave . '= \'' . $valor . '\', ';
        }
    }

    if (!empty($_FILES['foto_portada']['size'])) {
        $consulta .= 'foto_portada=\'' . $foto_portada . '\', ';  
    }


    $id = $_POST['id'];
    $consulta .= 'WHERE id = ' . $id . ';';
    $consulta = str_replace(", WHERE", " WHERE", $consulta);
    $resultado = mysqli_query($conexion, $consulta);


        if ($resultado){
            echo '<p class="pAviso">Modificación exitosa</p>';
            header('refresh:3; url=pelicula_listado.php');

        }else{
            echo '<p class="pAviso">No se pudo modificar</p>';
        }

    }else{
        echo '<p class="pAviso">No se realizó la modificación</p>';
    }

    desconectar($conexion);

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