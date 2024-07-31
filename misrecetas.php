<?php
include('database.php');

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['ID'])) {
    $_SESSION['mensaje'] = "Debe iniciar sesión para ver sus recetas.";
    header("Location: login.html");
    exit();
}

$usuario_id = $_SESSION['ID']; // Obtener el ID del usuario desde la sesión

// Preparar la consulta para obtener las recetas del usuario actual
$stmt = $conexion->prepare("SELECT titulo, descripcion, ingredientes, instrucciones FROM recetas WHERE usuario_id = ?");
if ($stmt) {
    $stmt->bind_param('i', $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Mostrar recetas
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="receta">';
            echo '<h2>' . htmlspecialchars($row['titulo']) . '</h2>';
            echo '<p><strong>Descripción:</strong> ' . htmlspecialchars($row['descripcion']) . '</p>';
            echo '<p><strong>Ingredientes:</strong> ' . htmlspecialchars($row['ingredientes']) . '</p>';
            echo '<p><strong>Instrucciones:</strong> ' . htmlspecialchars($row['instrucciones']) . '</p>';
            echo '</div>';
        }
    } else {
        echo '<p>No has subido ninguna receta todavía.</p>';
    }

    $stmt->close();
} else {
    // Error en la preparación de la consulta
    echo '<p>Error al consultar las recetas.</p>';
}

$conexion->close();
?>
