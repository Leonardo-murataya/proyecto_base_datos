<?php
// importar el archivo de configuración de la base de datos
require '../config/database.php';
// Iniciar la sesión
session_start();

// Verificar si el usuario no ha iniciado sesión
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

// Variables de la base de datos y de las tablas seleccionadas
$selected_db = $_SESSION['db'];
$selected_table = $_SESSION['table'];

$pdo->exec("USE $selected_db");
$stmt = $pdo->query("SELECT * FROM $selected_table LIMIT 10");
$rows = $stmt->fetchAll();
?>
// HTML
// Pendiente

<?php
