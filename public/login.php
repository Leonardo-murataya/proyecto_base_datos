<?php
require '../config/database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Aquí agregar la lógica de autenticación
}
?>

    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Iniciar Sesión</title>
    </head>
    <body>
    <h1>Iniciar Sesión</h1>
    <form method="post" action="login.php">
        <label for="username">Usuario:</label>
        <input type="text" id="username" name="username">
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password">
        <input type="submit" value="Iniciar Sesión">
    </form>
    </body>
    </html>
<?php
