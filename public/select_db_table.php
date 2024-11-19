<?php
require '../config/database.php';
// Iniciar la sesión
session_start();

// Verificar si el usuario no ha iniciado sesión
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

// Verificar si se ha enviado el formulario
// pendiente de implementar
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Seleccionar BD y Tabla</title>
</head>
<body>
<h1>Seleccionar Base de Datos y Tabla</h1>
<form method="post" action="select_db_table.php">
    <label for="db">Base de Datos:</label>
    <input type="text" id="db" name="db">
    <label for="table">Tabla:</label>
    <input type="text" id="table" name="table">
    <input type="submit" value="Seleccionar">
</form>
</body>
</html>
