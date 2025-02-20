<?php
?>
    <!-- La razón por la cual no tenemos un control aquí es porque esta página solamente es invocada. Siempre tendrá una sesión activa antes
    de aparecer. -->

    <section id="menu">
    
    <article id="usuario">

        <!-- Option select para cuando tengan foto o no -->
        <figure><img src="<?php if(!empty($_SESSION['foto'])){echo '../img/usuarios/' . $_SESSION['foto'];}else{echo '../img/usuarios/usuario_default.png';} ?>"></figure>

        <p><?php echo $_SESSION['usuario']; ?></p>

        <a href="salir.php">cerrar sesión</a>



    </article>

    <!-- Formato menu para html -->
    <article>
    <h2>Usuarios</h2>
    <ul>
        <?php
        if ($_SESSION['tipo'] == 'Administrador') {
        echo '<li><a href="usuario_alta.php">Nuevo usuario</a></li>';
        }
        ?>
        <li><a href="usuario_listado.php">Listado usuarios</a></li>
    </ul>
    </article>
    <article>
    <h2>Peliculas</h2>
    <ul>
        <?php
        if ($_SESSION['tipo'] == 'Administrador') {
        echo '<li><a href="pelicula_alta.php">Agregar pelicula</a></li>';
        }
        ?>
    </ul>
    <ul>
        <li><a href="pelicula_listado.php">Listar pelicula</a></li>
    </ul>
    <ul>
        <li><a href="pelicula_favorito.php?id=10000">Listar favoritas</a></li>
    </ul>
    </article>
    </section>

<?php
?>