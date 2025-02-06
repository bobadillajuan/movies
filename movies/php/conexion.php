<?php

    
    function conectar(){
        $servidor = 'localhost';
        $usuario = 'root';
        $clave = '';
        $db = 'peliculas';
        $conexion = mysqli_connect($servidor, $usuario, $clave, $db);

        if (!$conexion) {
            echo '<p>Error al conectar!</p>';
        }else{
            // printf("Conexion exitosa");
            return($conexion);
        }
    }

    function desconectar($conexion){
        if ($conexion) {
            $desco = mysqli_close($conexion);
            if ($desco) {
                // echo '<p id="desconexion">Desconexion exitosa!</p>';
            }else{
                echo '<p>Error al intentar conectarse!</p>';
            }
        }else{
            echo '<p>No se pudo conectar, no existe la conexión!</p>';
        }
    }



?>