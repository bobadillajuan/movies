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
                    <th>Mail</th>
                    <th>Fecha alta</th>
                    <th>Tipo</th>
                    <th>Modificar</th>
                    <th>Eliminar</th>
                    </tr>


            <?php

            while ($fila = mysqli_fetch_array($resultado_consulta)) {

                echo '<tr class="datos">';
                echo '<td>'.$fila['legajo'].'</td>';
                echo '<td><figure><img src="'.$fila['foto'].'"></figure></td>';
                echo '<td>'.$fila['apellido'].'</td>';
                echo '<td>'.$fila['nombres'].'</td>';
                echo '<td>'.$fila['correo']'</td>';

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