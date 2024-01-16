<?php
//Iniciar la sesión y la conexión a la BD
require_once('includes/conexion.php');
//Recoger los datos del formulario
if(isset($_POST)){
    //Borrar error antiguo
    if(isset($_SESSION['error_login'])){
        session_unset();
    }

    //Recoger datos del formulario
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    //Consulta para comprobar las credenciales del usuario
    $sql = "SELECT * FROM usuarios WHERE email = '$email'";

    $login = mysqli_query($db, $sql);

    if($login && mysqli_num_rows($login) == 1){
        $usuario = mysqli_fetch_assoc($login);
        $verify = password_verify($password, $usuario['password']);

        if($verify){
            //Utilizar una sesión para guardar los datos del usuario loggeado
            $_SESSION['usuario'] = $usuario;
        } else {
            $_SESSION['error_login'] = "Login Incorrecto";
        }
    } else {
        //Mensaje de error
        $_SESSION['error_login'] = "Login Incorrecto";
    }
    

}
 //Redirigir al index
 header('Location: index.php');
?>