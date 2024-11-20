<?php
function getDatabaseConnection() {
    // El isset() sirve para verificar si una variable está definida o no
    if (isset($_SESSION['db_info'])) {
        $host = $_SESSION['db_info']['host'];
        $db = $_SESSION['db_info']['db'];
        $user = $_SESSION['db_info']['user'];
        $pass = $_SESSION['db_info']['pass'];

        $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Sirve para lanzar excepciones en caso de error
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Sirve para que los resultados se devuelvan como arreglos asociativos
            PDO::ATTR_EMULATE_PREPARES   => false, // Sirve para desactivar las consultas preparadas emuladas o evitar inyecciones SQL
        ];

        try {
            return new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $error) {
            die('Conexión fallida: ' . $error->getMessage());
        }
    }
    return null;
}
?>
