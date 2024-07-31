<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['ID'])) {
    $_SESSION['mensaje'] = "Debe iniciar sesión para acceder a esta página.";
    header("Location: login.html");
    exit();
}

// Conectar a la base de datos
include('database.php');

// Mensaje de estado
$message = '';

// Variables para almacenar la información del usuario encontrado
$user = null;

// Verificar si se ha enviado el formulario de búsqueda
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search_username'])) {
    $search_username = trim($_POST['search_username']);  // Sanitizar entrada

    // Buscar el usuario por nombre de usuario
    $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE Usuario = ?");
    if ($stmt) {
        $stmt->bind_param('s', $search_username);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $user = $resultado->fetch_assoc();
        } else {
            $message = "Usuario no encontrado.";
        }

        $stmt->close();
    } else {
        $message = "Error en la consulta SQL.";
    }
}

// Verificar si se ha enviado el formulario de edición
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_user'])) {
    $user_id = $_POST['user_id'];
    $user_name = $_POST['user_name'];
    $user_password = $_POST['user_password'];

    // Actualizar la información del usuario
    $stmt = $conexion->prepare("UPDATE usuarios SET Usuario = ?, Contraseña = ? WHERE Id = ?");
    if ($stmt) {
        $stmt->bind_param('ssi', $user_name, $user_password, $user_id);

        if ($stmt->execute()) {
            $message = "Usuario actualizado exitosamente.";
        } else {
            $message = "Error al actualizar el usuario.";
        }

        $stmt->close();
    } else {
        $message = "Error en la consulta SQL.";
    }
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="reset.css">
</head>
<body>

<h1>Editar Usuario</h1>

<!-- Formulario de búsqueda de usuario -->
<form method="post" action="editar.php">
    <label for="search_username">Usuario para buscar:</label>
    <input type="text" id="search_username" name="search_username" required>
    <input type="submit" value="Buscar">
    <a href="panel_admin.php">Volver al panel de administrador</a>
</form>

<?php if ($user): ?>
    <!-- Formulario de edición de usuario -->
    <form method="post" action="editar.php">
        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['Id']); ?>">
        
        <label for="user_name">Nombre de usuario:</label>
        <input type="text" id="user_name" name="user_name" value="<?php echo htmlspecialchars($user['Usuario']); ?>" required>
        
        <label for="user_password">Contraseña:</label>
        <input type="text" id="user_password" name="user_password" value="<?php echo htmlspecialchars($user['Contraseña']); ?>" required>
        
        <input type="submit" name="edit_user" value="Actualizar Usuario">
        <a href="panel_admin.php">Volver al panel de administrador</a>
    </form>
<?php endif; ?>

<?php if ($message): ?>
    <p><?php echo htmlspecialchars($message); ?></p>
<?php endif; ?>

</body>
</html>
