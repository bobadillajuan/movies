<?php
    session_start();
    $ruta = '../css';
    require_once("../html/encabezado.html");
?>

<?php 
    
    require_once('menu.php');
    require_once('conexion.php');
    $conexion = conectar();

    $consulta = 'SELECT * FROM usuario'; 

    //Esto hará la consulta y nos devolverá un valor que podemos usar para verificar que se hizo correctamente.
    $resultado_consulta = mysqli_query($conexion, $consulta);

    if ($resultado_consulta) {
        
       if (mysqli_num_rows ($resultado_consulta)) {

            ?>
            <article id="articleTabla">
                <table class="tabla">
                    <tr class="titulos">
                    <th>Usuario</th>
                    <th>Foto</th>
                    <th>Mail</th>
                    <th>Fecha Alta</th>
                    <th>Tipo</th>
                    <th>Modificar</th>
                    <th>Eliminar</th>
                    </tr>


            <?php

            while ($fila = mysqli_fetch_array($resultado_consulta)) {

                echo '<tr class="datos">';
                echo '<td>'.$fila['usuario'].'</td>';
                if ($fila['foto']) {
                    echo '<td><figure><img src="../img/usuarios/'.$fila['foto'].'"></figure></td>';
                }else{
                    echo '<td><figure><img src="../img/usuarios/usuario_default.png"></figure></td>';
                }
                echo '<td>'.$fila['mail'].'</td>';
                echo '<td>'.$fila['fecha_alta'].'</td>';
                echo '<td>'.$fila['tipo'].'</td>';
                //Tenemos que hacer una petición y un link para poder eliminar y modificar usuarios.
                ?><td> <a href="usuario_modificar.php?id=<?php echo$fila['id']?>"><img src="../img/edit_pencil.png"></a> </td><?php
                ?><td> <a href="usuario_eliminar.php?id=<?php echo$fila['id']?>"><img src="../img/trash_empty.png"></a> </td><?php
                echo '</tr>';
            }
    
            echo '</table>';
            echo '</article>';

       }else{
           echo '<p>No encontramos el usuario</p>';
           header('refresh:4; url=../index.php');

       }

    }else{
        echo '<p>Error en la consulta</p>';
        header('refresh:4; url=../index.php');
    }

    
    desconectar($conexion);

?>



<?php
    require_once("../html/pie.html");
?>