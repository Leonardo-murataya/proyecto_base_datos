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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animación de Texto</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
<div class="divCenter">
    <h1>Administra tu Base de Datos</h1>

    <div class="contenedor">
        <div class="contenedor__contenido rotating-text">
            <p>Ideal para</p>
            <p>
                <span class="word w-1">Crear datos</span>
                <span class="word w-2">Leer datos</span>
                <span class="word w-3">Actualizar datos</span>
                <span class="word w-4">Eliminar datos</span>
            </p>

        </div>
    </div>

    <form class="formCenter" method="post" action="login.php">
        <label for="host">Host:</label>
        <input type="text" id="host" name="host" required>
        <label for="db">Base de Datos:</label>
        <input type="text" id="db" name="db" required>
        <label for="user">Usuario:</label>
        <input type="text" id="user" name="user" required>
        <label for="pass">Contraseña:</label>
        <input type="password" id="pass" name="pass" required>
        <input class="button" type="submit" value="Iniciar Sesión">
    </form>
</div>

<script src="../assets/js/app.js"></script>
</body>
</html>