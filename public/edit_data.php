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

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: view_data.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $columns = array_keys($_POST);
    $values = array_values($_POST);
    $set_clause = implode(", ", array_map(fn($col) => "$col = ?", $columns));

    $stmt = $pdo->prepare("UPDATE $selected_table SET $set_clause WHERE id = ?");
    $stmt->execute([...$values, $id]);

    header('Location: view_data.php?message=Registro actualizado');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM $selected_table WHERE id = ?");
$stmt->execute([$id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$row) {
    header('Location: view_data.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Registro</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <header>
        <h1>Editar Registro en la Tabla: <?php echo htmlspecialchars($selected_table); ?></h1>
    </header>
    <main>
        <form method="post" action="edit_data.php?id=<?php echo $id; ?>">
            <?php foreach ($row as $column => $value): ?>
                <div class="form-group">
                    <label for="<?php echo $column; ?>"><?php echo htmlspecialchars($column); ?>:</label>
                    <input type="text" id="<?php echo $column; ?>" name="<?php echo $column; ?>" value="<?php echo htmlspecialchars($value); ?>">
                </div>
            <?php endforeach; ?>
            <div class="form-group">
                <input type="submit" value="Actualizar">
            </div>
        </form>
        <a href="view_data.php">Volver</a>
    </main>
    <footer>
        <p>&copy; <?php echo date('Y'); ?> Tu Compañía</p>
    </footer>
</body>
</html>