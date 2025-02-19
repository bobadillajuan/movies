<?php
    session_start();
    $ruta = '../css';
    require_once("../html/encabezado.html");
?>

<?php 

    if(!empty($_POST['usua']) && !empty($_POST['cont']) ){
    
    require_once('conexion.php');
    $conexion = conectar();

    $usuario = $_POST['usua'];
    $contraseña = sha1($_POST['cont']);
    // $contraseña = $_POST['cont'];

    //En esta consulta se pide que coincidan los datos de la tabla con los enviados desde la página
    $consulta = 'SELECT usuario, foto, mail, tipo FROM usuario WHERE usuario = \''.$usuario.'\' AND password = \''.$contraseña.'\''; 

    print($consulta);

    //Esto hará la consulta y nos devolverá un valor que podemos usar para verificar que se hizo correctamente.
    $resultado_consulta = mysqli_query($conexion, $consulta);

    // var_dump($resultado_consulta);

    // $resultado es un booleano
    if ($resultado_consulta) {
        
        //a pesar de que duevuelve un int, si es mas de 0 entonces es True
       if (mysqli_num_rows($resultado_consulta)) {
        
        //Hacemos que los datos de nuestra DB sean guardados en las variables de sesión. ESTOS SON DATOS DE SESION Y NO DE COOKIES
        $fila = mysqli_fetch_array($resultado_consulta);
        $_SESSION['usuario'] = $fila['usuario'];
        $_SESSION['foto'] = $fila['foto'];
        $_SESSION['mail'] = $fila['mail'];
        $_SESSION['tipo'] = $fila['tipo'];

        //Aviso de inicio de sesión
        echo '<p class="pAviso">¡Incio de sesión exitoso!</p>';
        header('refresh:0; url=pelicula_listado.php');

       }else{

        //Aviso de inicio de sesión fallido
        echo '<p>No encontramos el usuario</p>';
        header('refresh:4; url=../index.php');

       }

    }else{
        //Este mensaje solo nos debería aparecer a nosotros durante el codeo
        echo '<p>Error en la consulta</p>';
        header('refresh:4; url=../index.php');
    }

    //Siempre tenemos que hacer la desconexion independientemente de que se entre o no a la base de datos
    desconectar($conexion);

    }else{
        //No se ingresaron datos en el formulario
        echo '<p><strong> Faltan datos </strong></p>';
    }


?>



<?php
    require_once("../html/pie.html");
?>