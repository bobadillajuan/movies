<?php

session_start();
$ruta = '../css';
require_once("../html/encabezado.html");
if (!empty($_SESSION['usuario'])) { 
 
    require_once('menu.php');
    require_once('conexion.php');
    $conexion = conectar();

    if (!empty($_COOKIE[$_SESSION['usuario']]) && isset($_COOKIE[$_SESSION['usuario']])) {

        $favoritas = $_COOKIE[$_SESSION['usuario']];
        $favoritasArreglo = explode(',', $favoritas);
        $consulta = 'SELECT * FROM pelicula WHERE ';
        foreach ($favoritasArreglo as $clave => $valor){
            $consulta .= 'id=\''. $valor . '\' OR '; 
        }
        $consulta = rtrim($consulta,'OR ');

        // rtrim es importante para sacar lo que esté de más 

        $resultado_consulta = mysqli_query($conexion, $consulta);

        desconectar($conexion);

        //Reutilizo el código para el listado de peliculas

        if (mysqli_num_rows ($resultado_consulta)) {

            ?>
            <section class="listadoPeliculas">
            <h2>Peliculas favoritas</h2>
            <?php

            while ($fila = mysqli_fetch_array($resultado_consulta)) {

                ?>
                <section class="listadoPeliculas">
                <article class = "articlePeliculaIndividual">
                    <article class="articlePortada">
                        <figure class="portadaPelicula">
                        <?php

                        if($fila['foto_portada']){
                        echo '<img src="../img/portadas/'.$fila['foto_portada'].'">';
                        }else{
                            echo '<img src="../img/portadas/sin_imagen.png">';
                        }
                        ?>
                        </figure>
                    </article>

                    <article class="articleInfoPelicula">
                        <h4 class="tituloPelicula"><?php echo $fila['titulo'];?></h4>
                        <p class="pPelicula">Género: <?php echo $fila['genero'];?></p>
                        <p class="pPelicula">Fecha de estreno: <?php echo $fila['fecha_estreno'];?></p>
                        <p class="pPelicula">Duración: <?php echo $fila['duracion'];?></p>
                        <!-- Se supone que desde aquí tambien tengo que tener estas opciones? -->
                        <figure class="opcionesPelicula">
                        <a href="pelicula_favorito_add.php?id=<?php echo$fila['id'];?>"><img src="../img/estrella.png"></a>
                            <?php
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
            echo '<p class="pAviso">No Hay peliculas favoritas!</p>';
        }
    }else{
        echo '<p class="pAviso">No Hay peliculas favoritas!</p>';
    }


} else {
    echo '<h2>No inició sesión</h2>';
    header('refresh:3; ../index.php');
}

?>