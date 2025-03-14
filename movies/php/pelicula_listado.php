<?php
    session_start();
    $ruta = '../css';
    require_once("../html/encabezado.html");
?>

<?php 
    
//Una vez que se inicie sesión las variable $_SESSION van a estar ahi para siempre, hasta que se las cierre.
if (!empty($_SESSION['usuario'])) { 
    
    require_once('menu.php');
    require_once('conexion.php');
    $conexion = conectar();

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

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://imdb.iamidiotareyoutoo.com/search?q=the"); //Para la API que queriamos usar, no la del tutorial.
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $data = curl_exec($ch);
    
    $status_info = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    $decodedData = json_decode($data, true);
    $movies = $decodedData['description'];

    foreach ($movies as $key) {

        ?>
                <article class = "articlePeliculaIndividual">
                    <article class="articlePortada">
                        <figure class="portadaPelicula">
                        <?php
                        if($key['#IMG_POSTER']){
                        echo '<img src="'.$key['#IMG_POSTER'].'">';
                        }else{
                            echo '<img src="../img/portadas/sin_imagen.png">';
                        }
                        ?>
                        </figure>
                    </article>

                    <article class="articleInfoPelicula">
                        <h4 class="tituloPelicula"><?php echo $key['#TITLE'];?></h4>
                        <p class="pPelicula">Actores: <?php echo $key['#ACTORS'];?></p>
                        <p class="pPelicula">Fecha de estreno: <?php echo $key['#YEAR'];?></p>
                    </article>


                </article>

                <?php



    }


    echo "\n Información de error: " . $status_info;
    curl_close($ch);

    ?>

    </section class="listadoPeliculas">
    <?php
    

} else {
    echo '<h2>No inició sesión</h2>';
    header('refresh:3; ../index.php');
}

?>

<?php
    require_once("../html/pie.html");
?>