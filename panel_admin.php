<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['ID'])) {
    $_SESSION['mensaje'] = "Debe iniciar sesión para acceder al dashboard.";
    header("Location: login.html");
    exit();
}

// Conectar a la base de datos
include('database.php');

// Obtener la lista actual de IDs de administradores desde la base de datos
$admin_ids = [];
$stmt = $conexion->prepare("SELECT admin_id FROM admin_ids");
$stmt->execute();
$resultado = $stmt->get_result();
while ($row = $resultado->fetch_assoc()) {
    $admin_ids[] = $row['admin_id'];
}

// Verificar si el usuario es administrador
$is_admin = in_array($_SESSION['ID'], $admin_ids);

if (!$is_admin) {
    echo "<script type=\"text/javascript\">alert('Acceso denegado'); window.location='login.html';</script>";
    exit();
}

// Inicializar mensaje
$message = '';

// Verificar si se ha enviado el formulario de adición de ID
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['new_admin_id'])) {
    $new_admin_id = $_POST['new_admin_id'];

    // Verificar si el ID ingresado existe en la base de datos de usuarios
    $stmt = $conexion->prepare("SELECT Id FROM usuarios WHERE Id = ?");
    $stmt->bind_param('i', $new_admin_id);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        // Verificar si el ID ya es un administrador
        if (!in_array($new_admin_id, $admin_ids)) {
            // Agregar el ID a la lista de administradores en la base de datos
            $stmt = $conexion->prepare("INSERT INTO admin_ids (admin_id) VALUES (?)");
            $stmt->bind_param('i', $new_admin_id);

            if ($stmt->execute()) {
                $message = "ID de administrador agregado exitosamente.";
                // Actualizar la lista de administradores
                $admin_ids[] = $new_admin_id;
            } else {
                $message = "Error al agregar el ID de administrador.";
            }
        } else {
            $message = "El ID de administrador ya está en la lista.";
        }
    } else {
        $message = "ID de usuario no encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Administrador</title>
    <link rel="stylesheet" href="reset.css">
</head>
<body>

<h1>Agregar ID de Administrador</h1>

<!-- Formulario para agregar ID de administrador -->
<form method="post" action="panel_admin.php">
    <label for="new_admin_id">ID del usuario para promover a administrador:</label>
    <input type="text" id="new_admin_id" name="new_admin_id" required>
    <input type="submit" value="Agregar">
</form>

<h2>Administradores Actuales</h2>
<form method="post" action="editar_admin.php">
    <label for="admin_select">Seleccionar administrador para editar:</label>
    <select id="admin_select" name="admin_id">
        <?php foreach ($admin_ids as $id): ?>
            <option value="<?php echo htmlspecialchars($id); ?>"><?php echo htmlspecialchars($id); ?></option>
        <?php endforeach; ?>
    </select>
</form>
<form action="editar.php" method="get">
    <input type="submit" value="Editar Usuario">
    <a href="Mainpage.php">Volver a la pagina principal</a>
</form>

<?php if ($message): ?>
    <p><?php echo htmlspecialchars($message); ?></p>
<?php endif; ?>

</body>
</html>
