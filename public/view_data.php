<?php
session_start();
require '../config/database.php';

$pdo = getDatabaseConnection();
if (!$pdo) {
header('Location: login.php');
exit;
}

$selected_db = $_SESSION['db_info']['db'];
$selected_table = $_SESSION['table'];

$pdo->exec("USE $selected_db");
$stmt = $pdo->query("SELECT * FROM $selected_table LIMIT 10");
$rows = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver Datos</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
<h1>Datos de la Tabla: <?php echo htmlspecialchars($selected_table); ?></h1>
<a href="add_data.php">Agregar Nuevo Registro</a>
<table border="1">
    <thead>
    <tr>
        <?php foreach ($rows[0] as $column => $value): ?>
            <th><?php echo htmlspecialchars($column); ?></th>
        <?php endforeach; ?>
        <th>Acciones</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($rows as $row): ?>
        <tr>
            <?php foreach ($row as $value): ?>
                <td><?php echo htmlspecialchars($value); ?></td>
            <?php endforeach; ?>
            <td>
                <a href="edit_data.php?id=<?php echo $row['id']; ?>">Editar</a>
                <a href="delete_data.php?id=<?php echo $row['id']; ?>">Eliminar</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<a href="select_db_table.php">Cambiar Tabla</a>
</body>
</html>