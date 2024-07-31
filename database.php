<?php
$usuario = "root";
$contrasena = "";  
$servidor = "localhost";
$basededatos = "TrabajoGd";

// Conexión a la base de datos
$conexion = mysqli_connect($servidor, $usuario, $contrasena, $basededatos);

// Verificar conexión
if (!$conexion) {
    die("La conexión falló: " . mysqli_connect_error());
}
?>