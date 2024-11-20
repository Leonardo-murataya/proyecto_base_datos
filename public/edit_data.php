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
    <title>Editar Datos</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
<h1>Editar Datos</h1>
<form method="post" action="edit_data.php">
    <input type="hidden" id="id" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
    <label for="name">Nombre:</label>
    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($row['name']); ?>">
    <input type="submit" value="Guardar">
</form>
</body>
</html>
