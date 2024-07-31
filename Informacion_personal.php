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

// Obtener el ID del usuario actual
$user_id = $_SESSION['ID'];

// Recuperar la información del usuario
$user = null;
$stmt = $conexion->prepare("SELECT * FROM usuarios WHERE Id = ?");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
}

// Verificar si se ha enviado el formulario de edición
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_user'])) {
    $user_name = $_POST['user_name'];
    $user_password = $_POST['user_password'];

    // Actualizar la información del usuario
    $stmt = $conexion->prepare("UPDATE usuarios SET Usuario = ?, Contraseña = ? WHERE Id = ?");
    if ($stmt) {
        $stmt->bind_param('ssi', $user_name, $user_password, $user_id);

        if ($stmt->execute()) {
            $message = "Informacion editada";
        } else {
            $message = "Error al actualizar la información.";
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
    <title>Editar Información</title>
    <link rel="stylesheet" href="reset.css">
</head>
<body>

<h1>Editar Información de la Cuenta</h1>

<!-- Formulario de edición de usuario -->
<form method="post" action="Informacion_personal.php">
    <div class="formulario">
    <label for="user_name">Nombre de usuario:</label>
    <input type="text" id="user_name" name="user_name" value="<?php echo htmlspecialchars($user['Usuario']); ?>" required>
    
    <label for="user_password">Contraseña:</label>
    <input type="text" id="user_password" name="user_password" value="<?php echo htmlspecialchars($user['Contraseña']); ?>" required>
    
    <input type="submit" name="edit_user" value="Actualizar Información">
    <a href="Mainpage.php">Volver</a>
    </div>

</form>

<?php if ($message): ?>
    <p><?php echo htmlspecialchars($message); ?></p>
<?php endif; ?>
    <h1>Mis recetas</h1>
<div class="content">
        <?php include('misrecetas.php'); ?>
    </div>

</body>
</html>
