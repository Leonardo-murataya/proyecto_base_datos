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
    if (!$auto_increment_column) {
        $auto_increment_column = $columns[0];
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    if ($selected_table) {
        $stmt = $pdo->prepare("SELECT * FROM $selected_table WHERE $auto_increment_column = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        if (!$row) {
            die("Registro no encontrado.");
        }
    } else {
        die("Tabla no seleccionada.");
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST[$auto_increment_column])) {
    $id = $_POST[$auto_increment_column];
    $data = [];
    foreach ($columns as $column) {
        if (isset($_POST[$column])) {
            $data[$column] = $_POST[$column];
        }
    }

    if ($selected_table) {
        $set_clause = implode(", ", array_map(fn($col) => "$col = :$col", array_keys($data)));
        $stmt = $pdo->prepare("UPDATE $selected_table SET $set_clause WHERE $auto_increment_column = :id");
        $data['id'] = $id;
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
    <title>Editar Datos</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
<h1>Editar Datos</h1>
<form method="post" action="edit_data.php">
    <?php foreach ($columns as $column): ?>
        <label for="<?php echo htmlspecialchars($column); ?>"><?php echo htmlspecialchars($column); ?>:</label>
        <input type="text" id="<?php echo htmlspecialchars($column); ?>" name="<?php echo htmlspecialchars($column); ?>" value="<?php echo htmlspecialchars($row[$column]); ?>" <?php echo $column === $auto_increment_column ? 'readonly' : 'required'; ?>>
    <?php endforeach; ?>
    <input type="submit" value="Guardar">
</form>
<a href="view_data.php">Volver</a>
</body>
</html>