<?php
function getDatabaseConnection() {
    if (isset($_SESSION['db_info'])) {
        $host = $_SESSION['db_info']['host'];
        $db = $_SESSION['db_info']['db'];
        $user = $_SESSION['db_info']['user'];
        $pass = $_SESSION['db_info']['pass'];

        $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
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