<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $host = $_POST['host'];
    $db = $_POST['db'];
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    $_SESSION['db_info'] = [
        'host' => $host,
        'db' => $db,
        'user' => $user,
        'pass' => $pass,
    ];

    // Verificar la conexión
    require '../config/database.php';
    if (getDatabaseConnection()) {
        header('Location: select_db_table.php');
        exit;
    } else {
        die('Conexión fallida.');
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
<h1>Iniciar Sesión en la Base de Datos</h1>
<form method="post" action="login.php">
    <label for="host">Host:</label>
    <input type="text" id="host" name="host" required>
    <label for="db">Base de Datos:</label>
    <input type="text" id="db" name="db" required>
    <label for="user">Usuario:</label>
    <input type="text" id="user" name="user" required>
    <label for="pass">Contraseña:</label>
    <input type="password" id="pass" name="pass" required>
    <input type="submit" value="Iniciar Sesión">
</form>
</body>
</html>
