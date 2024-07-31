<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['ID'])) {
    $_SESSION['mensaje'] = "Debe iniciar sesión para acceder al dashboard.";
    header("Location: login.html");
    exit();
}

include('database.php');

// Recuperar la lista de IDs de administradores desde la base de datos
$admin_ids = [];
$stmt = $conexion->prepare("SELECT admin_id FROM admin_ids");
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $admin_ids[] = $row['admin_id'];
}

// Verificar si el usuario es administrador
$is_admin = in_array($_SESSION['ID'], $admin_ids);

// Recuperar el nombre de usuario de la sesión
$username = isset($_SESSION['USERNAME']) ? $_SESSION['USERNAME'] : 'Usuario'; // Asegúrate de que 'USERNAME' está establecido durante el login
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Inicio</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>

<div class="sidebar" id="sidebar">
    <a href="Informacion_personal.php">Cuenta de usuario</a>
    <a href="login.html">Cerrar sesión</a>
    <?php if ($is_admin): ?>
        <a href="panel_admin.php" style="color: white;">Admin</a>
    <?php endif; ?>
</div>

<div class="content" id="content">
    <div class="navbar">
        <div class="menu-icon" onclick="toggleSidebar()">☰</div>
        <div class="nav-links">
            <a href="recetario.html">Recetas</a>
            <a href="#">Contacto</a>
            <a href="Informacion_personal.php"><?php echo htmlspecialchars($username); ?></a>
        </div>
    </div>
<div class="contenedor">
    <div class="info">
        <h1>Bienvenidos a Juandiegopastelería</h1>
        <p>En Juandiegopastelería, nos apasiona crear experiencias dulces y memorables para nuestros clientes. Ubicados en el corazón de la ciudad, nos especializamos en ofrecer una amplia variedad de pasteles, tartas y dulces que no solo deleitan el paladar, sino que también encantan la vista.</p>
    

    </div>
</div>
    <h2>Nuestros Productos:</h2>
    <div class="productos">
        <ul>
            <li class="container" ><strong>Tortas de Amapola:</strong> Un toque especial con semillas de amapola que añade un sabor único.  <img class="image-box"  src="imagenes\AMAPOLA.jpg" alt=""> </li>
            <li class="container" ><strong>Tortas de Chocolate:</strong> Deliciosas y ricas, perfectas para cualquier amante del chocolate. <img class="image-box"  src="imagenes\chocolatw.jpg" alt=""></li>
            <li  class="container"><strong>Torta 3 Leches:</strong> Una clásica y jugosa torta, bañada en una mezcla de tres leches. <img class="image-box"  src="imagenes\tresleches.jpg" alt=""></li>
            <li class="container" ><strong>Torta Red Velvet:</strong> Elegante y suave, con su distintivo color rojo y sabor aterciopelado. <img class="image-box" src="imagenes\redvelvet.jpg" alt=""> </li>
            <li class="container" ><strong>Mil Hojas:</strong> Capas crujientes de hojaldre con un relleno cremoso irresistible. <img class="image-box" src="imagenes\milhoja.jpg" alt=""> </li>
            <li class="container" ><strong>Quesillo:</strong> Nuestro tradicional flan, suave y cremoso, perfecto para cualquier ocasión. <img class="image-box" src="imagenes\quesillo.jpg" alt=""> </li>
            <li class="container" ><strong>Pie de Limón:</strong> Fresco y ácido, con una base crujiente y un relleno de limón cremoso. <img class="image-box" src="imagenes\piedelimon.jpg" alt=""> </li>
            <li class="container" ><strong>Galletas Polvorosas:</strong> Galletas que se deshacen en la boca, con un toque dulce y delicado. <img class="image-box" src="imagenes\galletas.jpg" alt=""> </li>
        </ul>

    </div>

<script>
    function toggleSidebar() {
        var sidebar = document.getElementById('sidebar');
        var content = document.getElementById('content');
        if (sidebar.style.left === '0px') {
            sidebar.style.left = '-250px';
            content.style.marginLeft = '0';
        } else {
            sidebar.style.left = '0px';
            content.style.marginLeft = '250px';
        }
    }
</script>

</body>
</html>
