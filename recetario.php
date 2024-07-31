<?php
session_start();
include('database.php');

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['ID'])) {
    $_SESSION['mensaje'] = "Debe iniciar sesión para enviar una receta.";
    header("Location: login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si los datos del formulario están definidos
    if (isset($_POST['titulo'], $_POST['descripcion'], $_POST['ingredientes'], $_POST['instrucciones'])) {
        // Recoger datos del formulario
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $ingredientes = $_POST['ingredientes'];
        $instrucciones = $_POST['instrucciones'];
        $usuario_id = $_SESSION['ID']; // Obtener el ID del usuario desde la sesión

        // Preparar la consulta para insertar los datos en la base de datos
        $stmt = $conexion->prepare("INSERT INTO recetas (titulo, descripcion, ingredientes, instrucciones, usuario_id) VALUES (?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param('ssssi', $titulo, $descripcion, $ingredientes, $instrucciones, $usuario_id);
            $stmt->execute();

            // Verificar si la inserción fue exitosa
            if ($stmt->affected_rows > 0) {
                echo '<script type="text/javascript">
                        alert("Receta guardada exitosamente"); 
                        window.location.href="Informacion_personal.php"; // Redirigir al perfil del usuario
                      </script>';
            } else {
                echo '<script type="text/javascript">
                        alert("Error al guardar la receta"); 
                        window.location.href="recetario.html"; // Redirigir al formulario de recetas
                      </script>';
            }

            $stmt->close();
        } else {
            // Error en la preparación de la consulta
            echo '<script type="text/javascript">
                    alert("Error en la consulta SQL."); 
                    window.location.href="recetario.html"; // Redirigir al formulario de recetas
                  </script>';
        }
    } else {
        // Si no se recibieron los datos del formulario, redirigir o mostrar mensaje de error
        echo '<script type="text/javascript">
                alert("Faltan datos en el formulario."); 
                window.location.href="recetario.html"; // Redirigir al formulario de recetas
              </script>';
    }
}

$conexion->close();
?>
