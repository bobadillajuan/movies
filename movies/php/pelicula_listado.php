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

    // $data = file_get_contents('https://imdb.iamidiotareyoutoo.com/search?q=1');
    // var_dump($data);
    // print_r($http_response_header);

    $payload = json_encode([
        "title" => "Updated Title"
    ]);

    $headers = [
        "Content-type: application/json; charset=UTF-8",
        "Accept-language: en"
    ];

    // $ch = curl_init();
    // curl_setopt_array($ch, [
    //     CURLOPT_URL => "https://jsonplaceholder.typicode.com/albums/1",
    //     CURLOPT_RETURNTRANSFER => "true",
    //     CURLOPT_CUSTOMREQUEST => "PATCH",
    //     CURLOPT_POSTFIELDS => $payload,
    //     CURLOPT_HTTPHEADER => $headers
    // ]);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://imdb.iamidiotareyoutoo.com/search?q=the"); //Para la API que queriamos usar, no la del tutorial.
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $data = curl_exec($ch);
    
    $status_info = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    $decodedData = json_decode($data, true);
    $movies = $decodedData['description'];

    foreach ($movies as $key) {
        echo "Title: " . $key["#TITLE"];
        // var_dump($key);
        echo "\n -----------------------------------------------------\n";
    }


    // var_dump($decodedData);

    // foreach ($decodedData as $movie) {

    //     var_dump($movie[2]);
    //     echo "\n\n";
    // }
    
    // var_dump($data);


    echo "\n Información de error: " . $status_info;
    curl_close($ch);

    ?>
    <section class="listadoPeliculas">

    <!-- Buscador de peliculas medio pelo -->
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
    }else{
        // Esta consulta trae toda la lista de una tabla en particular
        $consulta = 'SELECT * FROM pelicula'; 
    }

    $resultado_consulta = mysqli_query($conexion, $consulta);
    
    if ($resultado_consulta) {
        
       if (mysqli_num_rows ($resultado_consulta)) {

            ?>
              
            <!-- Para la vista general de como hacer un listado vease el TP 10 en esta misma parte. Esta versión tiene un buscador. -->

            <h2>Listado de películas</h2>

            <?php        
            
            // Recordemos que $fila = fetch array es para que toma una fila de la tabla a la vez, creando un bucle en donde 
            // $fila es un arreglo con los datos de la fila de la tabla actuales, una vez que se termina una instancia del bucle
            // pasa a la siguiente fila.

            while ($fila = mysqli_fetch_array($resultado_consulta)) {

                ?>
                
                <article class = "articlePeliculaIndividual">
                    <article class="articlePortada">
                        <figure class="portadaPelicula">
                        <?php
                        //En el formulario de carga le asignamos NULL a la portada si es que no se subió nada.
                        if($fila['foto_portada']){
                        echo '<img src="../img/portadas/'.$fila['foto_portada'].'">';
                        }else{
                            echo '<img src="../img/portadas/sin_imagen.png">';
                        }
                        ?>
                        </figure>
                    </article>

                    <article class="articleInfoPelicula">
                        <!-- Estos php en medio del html nos permiten escribir informacion traida desde la tabla -->
                        <h4 class="tituloPelicula"><?php echo $fila['titulo'];?></h4>
                        <p class="pPelicula">Género: <?php echo $fila['genero'];?></p>
                        <p class="pPelicula">Fecha de estreno: <?php echo $fila['fecha_estreno'];?></p>
                        <p class="pPelicula">Duración: <?php echo $fila['duracion'];?></p>

                        <!-- Opciones dentro de un html con imagenes. Estos links llevan consigo ID de los objetos que queremos apuntar -->
                        <figure class="opcionesPelicula"> 
                            <a href="pelicula_favorito_add.php?id=<?php echo$fila['id'];?>"><img src="../img/estrella.png"></a>
                            <?php
                            // Restriccion por tipo de sesión
                            if ($_SESSION['tipo'] == 'Administrador') {
                            ?>
                            <a href="confirmar_borrar.php?id=<?php echo$fila['id'];?>"><img src="../img/trash_empty.png"></a>
                            <?php
                            }
                            ?>
                            <?php
                            if ($_SESSION['tipo'] == 'Administrador' or $_SESSION['tipo'] == 'Editor') {
                            ?>
                            <a href="modificar.php?id=<?php echo$fila['id'];?>"><img src="../img/edit_pencil.png"></a>
                            <?php
                            }
                            ?>
                        </figure>
                    </article>
                    </article>
                <?php
                
            }

            echo '</section>';

            

       }else{
           echo '<p>No se encontraron peliculas!</p>';
           header('refresh:2; url=pelicula_listado.php');

       }

    }else{
        echo '<p>Error en la consulta</p>';
        header('refresh:4; url=../index.php');
    }

    
    desconectar($conexion);

} else {
    echo '<h2>No inició sesión</h2>';
    header('refresh:3; ../index.php');
}

?>



<?php
    require_once("../html/pie.html");
?>