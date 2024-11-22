<?php
function getDatabaseConnection() {
    if (isset($_SESSION['db_info'])) {
        $db_type = $_SESSION['db_info']['db_type'];
        $host = $_SESSION['db_info']['host'];
        $port = $_SESSION['db_info']['port'];
        $db = $_SESSION['db_info']['db'];
        $user = $_SESSION['db_info']['user'];
        $pass = $_SESSION['db_info']['pass'];

        $dsn = "";
        switch ($db_type) {
            case 'MySQL':
            case 'MariaDB':
                $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
                break;
            case 'PostgreSQL':
                $dsn = "pgsql:host=$host;port=$port;dbname=$db";
                break;
            case 'MS-Access':
                $dsn = "odbc:Driver={Microsoft Access Driver (*.mdb, *.accdb)};Dbq=$db;";
                break;
        }

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