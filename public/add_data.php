<?php
session_start();
require '../config/database.php';

$pdo = getDatabaseConnection();
if (!$pdo) {
header('Location: login.php');
exit;
}

// Falta terminar
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Datos</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
<h1>Agregar Datos</h1>
<form method="post" action="add_data.php">
    <label for="name">Nombre:</label>
    <input type="text" id="name" name="name">
    <input type="submit" value="Guardar">
</form>
</body>
</html>
