<?php
require_once 'includes/conexion.php';

if(isset($_SESSION['usuario']) && isset($_GET['id'])){
  $entrada_id = $_GET['id'];
  $id_usuario = $_SESSION['usuario']['id'];
  $sql = "DELETE FROM entradas WHERE id = $id_usuario AND id = $entrada_id";
  mysqli_query($db, $sql);  
}
header("Location: index.php");
?>