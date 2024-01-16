<?php
//CONEXION
$server = 'localhost';
$username = 'root';
$pass = '';
$database = 'blog';
$db = mysqli_connect($server, $username, $pass, $database);
mysqli_query($db, "SET NAMES 'utf8'");
// if($db){
//     echo "Conexion EXITOSA";
// } else {
//     echo "Conexión FALIIDA";
// }
//Iniciar la sesión
if(!isset($_SESSION)){
    session_start();
}
?>