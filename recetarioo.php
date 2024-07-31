<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Receta</title>
    <style>
        /* Estilo general del formulario */
form {
    max-width: 600px;
    margin: 30px auto;
    padding: 20px;
    background-color: #faeeee; /* Fondo claro para el formulario */
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Estilo para las etiquetas */
form label {
    display: block;
    font-weight: bold;
    margin-bottom: 8px;
    color: #333;
}

/* Estilo para los campos de texto */
form input[type="text"],
form textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-sizing: border-box; /* Incluye el padding en el tamaño total */
}

/* Estilo específico para el campo de texto de varias líneas */
form textarea {
    resize: vertical; /* Permite redimensionar verticalmente */
    height: 150px; /* Altura inicial */
}

/* Estilo para el botón de envío */
form input[type="submit"] {
    background-color: #F6B1B1;
    color: #fff;
    border: none;
    padding: 15px 20px;
    font-size: 1em;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

/* Estilo para el botón de envío en estado hover */
form input[type="submit"]:hover {
    background-color: #7a5353;
}

body {
    background-color: #ffc0c0; /* Fondo oscuro para el body */
    color: #E0E0E0; /* Color de texto claro para contraste */
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}
    </style>
</head>
<body>
    <form action="recetario.php" method="post">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" required>

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required></textarea>

        <label for="ingredientes">Ingredientes:</label>
        <textarea id="ingredientes" name="ingredientes" required></textarea>

        <label for="instrucciones">Instrucciones:</label>
        <textarea id="instrucciones" name="instrucciones" required></textarea>

        <input type="submit" value="Guardar Receta">
    </form>
</body>
</html>
