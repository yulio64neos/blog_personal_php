<?php
if(isset($_POST['submit'])){
    require_once 'includes/conexion.php';
    if(!isset($_SESSION)){
        session_start();
    }

    $nombre = isset($_POST['nombre']) ? mysqli_real_escape_string($db, $_POST['nombre']) : false;

    $apellidos = isset($_POST['apellidos']) ? mysqli_real_escape_string($db, $_POST['apellidos']) : false;

    $email = isset($_POST['email']) ? mysqli_real_escape_string($db, trim($_POST['email'])) : false;

    $password = isset($_POST['password']) ? mysqli_real_escape_string($db, $_POST['password']) : false;

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

    //Validar la contraseña
    if(!empty($password)){
        $password_validado = true;
    } else {
        $password_validado = false;
        $errores['password'] = "El password está vacia";
    }

    $guardar_usuario = false;
    if(count($errores) == 0){
        //INSERTAR USUARIO EN LA TABLA USUARIOS
        $guardar_usuario = true;

        //Cifrar la contraseña
        $password_segura = password_hash($password, PASSWORD_BCRYPT, ['cost' => 4]);
        
        $sql = "INSERT INTO usuarios VALUES(null, '$nombre', '$apellidos', '$email', '$password_segura', 'CURDATE()');";
        print_r($sql);
        $guardar = mysqli_query($db, $sql);

        // var_dump(mysqli_error($db));
        // die();

        if($guardar){
            $_SESSION['completado'] = "El registro se ha completado con éxito";
        } else {
            $_SESSION['errores']['general'] = "Fallo al guardar el usuario!!";
        }

    } else {
        $_SESSION['errores'] = $errores;
        header('Location: index.php');
    }
}
header('Location: index.php');
?>