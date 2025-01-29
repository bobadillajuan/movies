<?php
    session_start();
    $ruta = '../css';
    require_once("../html/encabezado.html");
?>

<?php 

if (!empty($_SESSION['usuario'])) { 

    if(!empty($_POST['usuario']) && !empty($_POST['contraseña']) && !empty($_POST['correo']) && !empty($_POST['fechaAlta'])){
    //permitimos que se haga una entrada sin una foto

    require_once('conexion.php');
    $conexion = conectar();

    $usuario= $_POST['usuario'];
    $contraseña = $_POST['contraseña']; 
    // Por alguna razon aqui el sha1 no me esta sirviendo
    $email = $_POST['correo'];
    $tipo = $_POST['tipo'];
    $fechaAlta = $_POST['fechaAlta'];
    

    //Trabajamos con el archivo


    if(!empty($_FILES['foto']['size']))
    {
    $nombreUsuario = $_FILES['foto']['name'];
    $ext = explode('.', $nombreUsuario);
    $rutaOrigen = $_FILES['foto']['tmp_name'];
    $destino = '../img/usuarios/' . $usuario . '.' . $ext[1];
    $resultado = move_uploaded_file($rutaOrigen, $destino);
    $foto_usuario = $usuario . '.' . $ext[1];
    }else{
        $foto_usuario = NULL;
    }



    $consulta = 'INSERT INTO usuario (usuario, password, mail, fecha_alta, tipo, foto) VALUES (\''.$usuario.'\', '.$contraseña.', \''.$email.'\', \''.$fechaAlta.'\', \''.$tipo.'\', \''.$foto_usuario.'\')'; 

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