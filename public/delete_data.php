<?php
session_start();
require '../config/database.php';

$pdo = getDatabaseConnection();
if (!$pdo) {
    header('Location: login.php');
    exit;
}

// Falta terminar

echo "Registro eliminado exitosamente";
header('Location: view_data.php');
exit;
?>
