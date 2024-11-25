<?php
session_start();
require '../config/database.php';

$pdo = getDatabaseConnection();
if (!$pdo) {
    header('Location: login.php');
    exit;
}

$selected_table = $_SESSION['table'] ?? null;
$auto_increment_column = null;

if ($selected_table) {
    // Obtener las columnas de la tabla seleccionada
    $stmt = $pdo->query("DESCRIBE $selected_table");
    $columns_info = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($columns_info as $column_info) {
        if ($column_info['Extra'] === 'auto_increment') {
            $auto_increment_column = $column_info['Field'];
            break;
        }
    }
    if (!$auto_increment_column) {
        $auto_increment_column = $columns_info[0]['Field'];
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if ($selected_table && $auto_increment_column) {

        $stmt = $pdo->prepare("DELETE FROM $selected_table WHERE $auto_increment_column = :id");
        $stmt->execute(['id' => $id]);

        header('Location: view_data.php');
        exit;

    }
}

?>