<?php
if(isset($_POST['submit'])){
    require_once 'includes/conexion.php';

    $nombre = isset($_POST['nombre']) ? mysqli_real_escape_string($db, $_POST['nombre']) : false;

    $apellidos = isset($_POST['apellidos']) ? mysqli_real_escape_string($db, $_POST['apellidos']) : false;

    $email = isset($_POST['email']) ? mysqli_real_escape_string($db, trim($_POST['email'])) : false;

    //Array de errores
    $errores = array();

    //Validar los datos antes de guardarlos en la base de datos
    //Validar campo nombre
    if(!empty($nombre) && !is_numeric($nombre) && !preg_match("/[0-9]/", $nombre)){
        //echo "El nombre es valido";
        $nombre_validado = true;
    } else {
        $nombre_validado = false;
        $errores['nombre'] = "El nombre no es valido";
    }

    //Validar campo apellido
    if(!empty($apellidos) && !is_numeric($apellidos) && !preg_match("/[0-9]/", $apellidos)){
        //echo "El nombre es valido";
        $apellido_validado = true;
    } else {
        $apellido_validado = false;
        $errores['apellidos'] = "El apellido no es valido";
    }

    //Validar el email
    if(!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)){
        //echo "El nombre es valido";
        $email_validado = true;
    } else {
        $email_validado = false;
        $errores['email'] = "El email no es valido";
    }

    $guardar_usuario = false;
    if(count($errores) == 0){
        $usuario = $_SESSION['usuario'];
        //INSERTAR USUARIO EN LA TABLA USUARIOS
        $guardar_usuario = true;

        //Comprobar si el email ya existe
        $sql = "SELECT id, email FROM usuarios WHERE email = '$email'";
        $isset_email = mysqli_query($db, $sql);
        $isset_user = mysqli_fetch_assoc($isset_email);
        
        if($isset_user['id'] == $usuario['id'] || empty($isset_user)){
            //ACTUALIZAR EL USUARIO
            
            $sql = "UPDATE usuarios SET ".
                   "nombre = '$nombre', ".
                   "apellidos = '$apellidos', ".
                   "email = '$email' ".
                   "WHERE id = ".$usuario['id'];
            $guardar = mysqli_query($db, $sql);
    
            // var_dump(mysqli_error($db));
            // die();
    
            if($guardar){
                $_SESSION['usuario']['nombre'] = $nombre;
                $_SESSION['usuario']['apellidos'] = $apellidos;
                $_SESSION['usuario']['email'] = $email;
    
                $_SESSION['completado'] = "Tus datos se han actualizado con éxito";
            } else {
                $_SESSION['errores']['general'] = "Fallo al guardar el actualizar tus datos!!";
            }
        } else {
            $_SESSION['errores']['general'] = "El usuario ya existe!!";
        }

    } else {
        $_SESSION['errores'] = $errores;
    }
}
header('Location: mis-datos.php');
?>