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

    if ($_SESSION['tipo'] == 'Administrador') {

    if($conexion && !empty($_GET['id'])){

    $id = $_GET['id'];

    $consulta = 'DELETE FROM usuario WHERE id= \''. $id .'\''; 

    $resultado = mysqli_query($conexion, $consulta);

    desconectar($conexion);


        if ($resultado){
            echo '<p class="pAviso">Eliminación exitosa</p>';
            header('refresh:3; url=usuario_listado.php');

        }else{
            echo '<p class="pAviso">No se pudo eliminar</p>';
        }

    }else{
        echo '<p class="pAviso">No se realizó la eliminación</p>';
    }

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