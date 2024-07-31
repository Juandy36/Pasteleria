<?php
session_start();
include('database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Datos del formulario convertidos en variables
    $ID = $_POST['id'];
    $Pass = $_POST['pass'];

    // Consulta SQL para verificar ID y contraseña
    $Sql = "SELECT Id, Contraseña, Usuario FROM usuarios WHERE Id = '".$ID."'";
    $result = mysqli_query($conexion, $Sql);

    // Almacenamos la cantidad de resultados encontrados
    $count = mysqli_num_rows($result);

    if ($count == 1) {
        // Almacenamos el resultado en un arreglo
        $row = mysqli_fetch_array($result);

        // Verificar la contraseña
        if ($row['Contraseña'] !== $Pass) {
            // Contraseña incorrecta
            echo '<script type="text/javascript">
                    alert("Contraseña incorrecta"); 
                    window.location.href="login.html"; 
                  </script>';
            exit();
        }

        // Iniciar sesión con el ID del usuario
        $_SESSION['ID'] = $ID;
        $_SESSION['USERNAME'] = $row['Usuario']; // Almacenar el nombre de usuario en la sesión

        // Redirigir según el tipo de usuario
        if ($ID == '1097500598') {
            header('Location: Mainpage.php'); // Redirigir a Mainpage.html si el ID es 1097500598
            exit();
        } else {
            header('Location: Mainpage.php'); // Redirigir a bienvenidos.html en caso contrario
            exit();
        }
    } else {
        // Si no hay coincidencias, mostrar mensaje de error y redirigir al formulario de inicio de sesión
        echo '<script type="text/javascript">
                alert("Usuario no existente"); 
                window.location.href="login.html"; 
              </script>';
        exit();
    }
}
?>
