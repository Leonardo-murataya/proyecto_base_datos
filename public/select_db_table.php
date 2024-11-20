<?php
session_start();
require '../config/database.php';

$pdo = getDatabaseConnection();
if (!$pdo) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['table'] = $_POST['table'];
    header('Location: view_data.php');
    exit;
}

$selected_db = $_SESSION['db_credentials']['db'];
$tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Seleccionar Tabla</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
<h1>Seleccionar Tabla en la Base de Datos: <?php echo htmlspecialchars($selected_db); ?></h1>
<form method="post" action="select_db_table.php">
    <label for="table">Tabla:</label>
    <select id="table" name="table">
        <?php foreach ($tables as $table): ?>
            <option value="<?php echo $table; ?>"><?php echo $table; ?></option>
        <?php endforeach; ?>
    </select>
    <input type="submit" value="Seleccionar">
</form>
<a href="login.php">Cambiar Base de Datos</a>
</body>
</html>