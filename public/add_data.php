<?php
session_start();
require '../config/database.php';

$pdo = getDatabaseConnection();
if (!$pdo) {
    header('Location: login.php');
    exit;
}

$selected_table = $_SESSION['table'] ?? null;
$columns = [];
$auto_increment_column = null;

if ($selected_table) {
    // Obtener las columnas de la tabla seleccionada
    $stmt = $pdo->query("DESCRIBE $selected_table");
    $columns_info = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($columns_info as $column_info) {
        $columns[] = $column_info['Field'];
        if ($column_info['Extra'] === 'auto_increment') {
            $auto_increment_column = $column_info['Field'];
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [];
    foreach ($columns as $column) {
        if (isset($_POST[$column])) {
            $data[$column] = $_POST[$column];
        }
    }

    if ($selected_table) {
        $placeholders = implode(", ", array_map(fn($col) => ":$col", array_keys($data)));
        $columns_str = implode(", ", array_keys($data));
        $stmt = $pdo->prepare("INSERT INTO $selected_table ($columns_str) VALUES ($placeholders)");
        $stmt->execute($data);

        header('Location: view_data.php');
        exit;
    } else {
        die("Tabla no seleccionada.");
    }
}
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
    <?php foreach ($columns as $column): ?>
        <?php if ($column === $auto_increment_column): ?>
            <label for="<?php echo htmlspecialchars($column); ?>"><?php echo htmlspecialchars($column); ?> (Opcional):</label>
            <input type="text" id="<?php echo htmlspecialchars($column); ?>" name="<?php echo htmlspecialchars($column); ?>">
            <small>Dejar en blanco para auto-incrementar</small>
        <?php else: ?>
            <label for="<?php echo htmlspecialchars($column); ?>"><?php echo htmlspecialchars($column); ?>:</label>
            <input type="text" id="<?php echo htmlspecialchars($column); ?>" name="<?php echo htmlspecialchars($column); ?>" required>
        <?php endif; ?>
    <?php endforeach; ?>
    <input type="submit" value="Guardar">
</form>
<a href="view_data.php">Volver</a>
</body>
</html>