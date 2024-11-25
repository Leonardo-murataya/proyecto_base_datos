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

$selected_db = $_SESSION['db_info']['db'];
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
<div class="divCenter space">
    <h1>Seleccionar Tabla en la Base de Datos: <?php echo htmlspecialchars($selected_db); ?></h1>
    <form class="formCenter" method="post" action="select_db_table.php">
        <div class="grid-container">
            <?php foreach ($tables as $table): ?>
                <button type="submit" name="table" value="<?php echo htmlspecialchars($table); ?>" class="grid-item">
                    <?php echo htmlspecialchars($table); ?>
                </button>
            <?php endforeach; ?>
        </div>
    </form>
    <div class="abajo links">
        <a href="logout.php">Cambiar Base de Datos</a>
    </div>
</div>
</body>
</html>