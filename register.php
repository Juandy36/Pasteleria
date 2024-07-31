<?php
include('database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo "Conectado satisfactoriamente<br>";

    // Verificar si se recibieron los datos correctamente
    if (!isset($_POST['id'], $_POST['name'], $_POST['user'], $_POST['pass'], $_POST['conpass'])) {
        echo "<script type=\"text/javascript\">alert('Todos los campos son obligatorios'); window.location='register.html';</script>";
        exit;
    }

    $id = $_POST['id'];
    $nombre = $_POST['name'];
    $user = $_POST['user'];
    $contraseña = $_POST['pass'];
    $confirmarcontraseña = $_POST['conpass'];

    // Verificar si las contraseñas coinciden
    if ($contraseña !== $confirmarcontraseña) {
        echo "<script type=\"text/javascript\">alert('Las contraseñas no coinciden'); window.location='register.html';</script>";
        exit;
    }

    // Encriptar la contraseña antes de almacenarla
    

    // Insertar los datos en la base de datos
    $sql = "INSERT INTO usuarios (Id, Usuario, Nombre, Contraseña) VALUES ('$id', '$user', '$nombre', '$contraseña')";
    
    $consulta = mysqli_query($conexion, $sql);

    if ($consulta) {
        echo "<script type=\"text/javascript\">alert('Datos almacenados'); window.location='login.html';</script>";
    } else {
        echo "<script type=\"text/javascript\">alert('Error al almacenar los datos'); window.location='register.html';</script>";
    }
}
?>
