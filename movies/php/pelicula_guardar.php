<?php
    session_start();
    $ruta = '../css';
    require_once("../html/encabezado.html");
?>

<?php 

if (!empty($_SESSION['usuario'])) { 

    if(!empty($_POST['titulo']) && !empty($_POST['duracion']) && !empty($_POST['genero']) && !empty($_POST['fechaEstreno'])){
    //permitimos que se haga una entrada sin una portada

    require_once('conexion.php');
    $conexion = conectar();

    $titulo = $_POST['titulo'];
    $duracion = $_POST['duracion'];
    $genero = $_POST['genero'];
    $fechaEstreno = $_POST['fechaEstreno'];

    //Trabajamos con el archivo


    if(!empty($_FILES['portada']['size']))
    {
    $nombrePortada = $_FILES['portada']['name'];
    $ext = explode('.', $nombrePortada);
    $rutaOrigen = $_FILES['portada']['tmp_name'];
    $destino = '../img/portadas/' . $titulo . '.' . $ext[1];
    $resultado = move_uploaded_file($rutaOrigen, $destino);
    $foto_portada = $titulo . '.' . $ext[1];
    }else{
        $foto_portada = NULL;
    }



    $consulta = 'INSERT INTO pelicula (titulo, duracion, genero, fecha_estreno, foto_portada) VALUES (\''.$titulo.'\', '.$duracion.', \''.$genero.'\', \''.$fechaEstreno.'\', \''.$foto_portada.'\')'; 

    $resultado_consulta = mysqli_query($conexion, $consulta);

    if ($resultado_consulta) {
           
        echo '<p class="pAviso">Consulta bien ejecutada</p>';
        header('refresh:1; url=pelicula_alta.php');

    }else{
        echo '<p class="pAviso">Error en la consulta</p>';
        header('refresh:3; url=pelicula_alta.php');
    }

    
    desconectar($conexion);

    }else{
        echo '<p><strong> Faltan datos </strong></p>';
    }

} else {
    echo '<h2>No inició sesión</h2>';
    header('refresh:3; ../index.php');
}

?>



<?php
    require_once("../html/pie.html");
?>