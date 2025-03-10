<?php
    session_start();
    $ruta = '../css';
    require_once("../html/encabezado.html");
?>

<?php 
    
//Una vez que se inicie sesión las variable $_SESSION van a estar ahi para siempre, hasta que se las cierre.
if (!empty($_SESSION['usuario'])) { 
    
    require_once('menu.php');
    // require_once('conexion.php');
    // $conexion = conectar();

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://imdb.iamidiotareyoutoo.com/search?q=the"); //Para la API que queriamos usar, no la del tutorial.
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $data = curl_exec($ch);
    
    $status_info = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    $decodedData = json_decode($data, true);
    $movies = $decodedData['description'];

    foreach ($movies as $key) {
        echo "Title: " . $key["#TITLE"];
        echo "<img src=" .$key["#IMG_POSTER"] . ">"; 
        // var_dump($key); 
        echo "\n -----------------------------------------------------\n";
    }

    echo "\n Información de error: " . $status_info;
    curl_close($ch);

    ?>
    <section class="listadoPeliculas">

    <!-- Buscador de peliculas -->
    <form action="" method="get" class="buscador">
                <div class="contenedor_buscador">
                    <input type="search" id="espaciobuscador" name="buscador" placeholder="buscar...">
                    <input type="submit" id="botonbuscador" value="buscar">
                </div>
    </form>  
    <?php
    if (!empty($_GET['buscador'])) {
        // Ejemplo de como usar buscador - NO DE COMO BUSCAR COINCIDENCIA
        $consulta = 'SELECT * FROM pelicula WHERE titulo LIKE \'%'.$_GET['buscador'].'%\''; 
    }else{$consulta = 'SELECT * FROM pelicula';}

    ?>
    <section class="listadoPeliculas">
    <?php
    

} else {
    echo '<h2>No inició sesión</h2>';
    header('refresh:3; ../index.php');
}

?>

<?php
    require_once("../html/pie.html");
?>