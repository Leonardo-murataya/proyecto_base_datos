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

$stmt = $pdo->query("DESCRIBE $selected_table");
$columns_info = $stmt->fetchAll(PDO::FETCH_ASSOC);

$auto_increment_column = null;
if ($columns_info) {
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

$search_id = $_GET['search_id'] ?? null;
$page = $_GET['page'] ?? 1;
$limit = 10;
$offset = ($page - 1) * $limit;

if ($search_id) {
    $stmt = $pdo->prepare("SELECT * FROM $selected_table WHERE $auto_increment_column = :id");
    $stmt->execute(['id' => $search_id]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $stmt = $pdo->query("SELECT COUNT(*) FROM $selected_table");
    $total_rows = $stmt->fetchColumn();
    $total_pages = ceil($total_rows / $limit);

    $stmt = $pdo->query("SELECT * FROM $selected_table LIMIT $limit OFFSET $offset");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$message = $_GET['message'] ?? null;

// Procesar consulta personalizada
$custom_query = $_POST['custom_query'] ?? null;
$custom_query_result = [];
if ($custom_query) {
    try {
        // Validar que la consulta sea un SELECT
        if (stripos($custom_query, 'SELECT') === 0) {
            $stmt = $pdo->query($custom_query);
            $custom_query_result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $message = 'Solo se permiten consultas SELECT.';
        }
    } catch (PDOException $e) {
        $message = 'Error en la consulta: ' . $e->getMessage();
    }
}
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
<nav>
<a href="add_data.php">Agregar Nuevo Registro</a>
</nav>

<form class="formTables" method="get" action="view_data.php">
    <label for="search_id">Buscar por ID:</label>
    <input type="text" id="search_id" name="search_id">
    <input class="buttonTables" type="submit" value="Buscar">
</form>

<!-- Formulario para consultas personalizadas -->
<form class="formTables" method="post" action="view_data.php">
    <label for="custom_query">Consulta SQL:</label>
    <textarea id="custom_query" name="custom_query" rows="4" cols="50"></textarea>
    <input class="buttonTables" type="submit" value="Ejecutar Consulta">
</form>

<?php if ($message): ?>
    <p><?php echo htmlspecialchars($message); ?></p>
<?php endif; ?>

<?php if ($custom_query_result): ?>
    <h2>Resultados de la Consulta Personalizada</h2>
    <table border="1">
        <thead>
        <tr>
            <?php foreach (array_keys($custom_query_result[0]) as $column): ?>
                <th><?php echo htmlspecialchars($column); ?></th>
            <?php endforeach; ?>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($custom_query_result as $row): ?>
            <tr>
                <?php foreach ($row as $column => $value): ?>
                    <td><?php echo htmlspecialchars($value); ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<br>
<h2>Resultados de la Tabla</h2>
<table>
    <thead>
    <tr>
        <?php foreach (array_keys($rows[0]) as $column): ?>
            <th><?php echo htmlspecialchars($column); ?></th>
        <?php endforeach; ?>
        <th>Acciones</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($rows as $row): ?>
        <tr>
            <?php foreach ($row as $column => $value): ?>
                <td><?php echo htmlspecialchars($value); ?></td>
            <?php endforeach; ?>
            <td>
                <a href="edit_data.php?id=<?php echo $row[$auto_increment_column]; ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="15" height="15" stroke-width="1">
                    <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4"></path>
                    <path d="M13.5 6.5l4 4"></path>
                </svg></a>
                <a href="delete_data.php?id=<?php echo $row[$auto_increment_column]; ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="15" height="15" stroke-width="1">
                    <path d="M4 7l16 0"></path>
                    <path d="M10 11l0 6"></path>
                    <path d="M14 11l0 6"></path>
                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                </svg></a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php if (!$search_id): ?>
    <div class="pagination">
        <p>Paginas de registros</p>
        <?php if ($page > 1): ?>
            <a href="?page=1">&laquo; Inicio</a>
            <a href="?page=<?php echo $page - 1; ?>">&lsaquo; Anterior</a>
        <?php endif; ?>

        <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
            <a href="?page=<?php echo $i; ?>" <?php if ($i == $page) echo 'class="active"'; ?>><?php echo $i; ?></a>
        <?php endfor; ?>

        <?php if ($page < $total_pages): ?>
            <a href="?page=<?php echo $page + 1; ?>">Siguiente &rsaquo;</a>
            <a href="?page=<?php echo $total_pages; ?>">Fin &raquo;</a>
        <?php endif; ?>
    </div>
<?php endif; ?>

<a href="select_db_table.php">Cambiar Tabla</a>
<script src="../assets/js/app.js"></script>
</body>
</html>