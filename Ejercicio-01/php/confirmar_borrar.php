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

    $consulta = 'SELECT titulo FROM pelicula WHERE id= \''. $id .'\''; 

    $resultado = mysqli_query($conexion, $consulta);

    desconectar($conexion);


    if (mysqli_num_rows($resultado) > 0){

            $fila = mysqli_fetch_array($resultado);

            echo '<article class="confirmarBorrarArticle">';
            echo '<h2>Eliminar película</h2>';
            echo '<p>¿Está seguro que desea eliminar la pelicula <strong>'.$fila['titulo'].'</strong>?</p>';
            echo '<a class="botonConfirmar" href="borrar.php?id='.$id.'">Aceptar</a>';
            echo '<a class="botonConfirmar" href="pelicula_listado.php">Cancelar</a>';
            echo '</article>';
        }

    }

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