# Aplicación Cliente para Gestión de Bases de Datos Relacionales

## Descripción
Este proyecto consiste en una aplicación cliente prototipo que permite realizar tareas mínimas básicas de gestión para Bases de Datos Relacionales. La aplicación interactúa con la base de datos recuperando metadatos de forma dinámica utilizando la base de datos especial `INFORMATION_SCHEMA`. Puede ser desarrollada como una aplicación de escritorio, web o móvil.

## Requerimientos
- **PHP** (7.3 o superior)
- **Base de datos** (MySQL, MariaDB, PostgreSQL o MS-Access)
- **Composer** para la gestión de dependencias

## Instalación
1. **Clona el repositorio**:
   ```bash
   https://github.com/Leonardo-murataya/proyecto_base_datos.git
   cd proyecto_base_datos

2. **Instala las dependencias:**
   ```bash
   composer install

3. **Configura la conexión a la base de datos:**
   **Edita el archivo config/database.php con los detalles de tu base de datos:**
   ```bash
   <?php
   $host = 'localhost';
   $db = 'mi_base_de_datos';
   $user = 'mi_usuario';
   $pass = 'mi_contraseña';
   $charset = 'utf8mb4';

   $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
   $options = [
       PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
       PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
       PDO::ATTR_EMULATE_PREPARES   => false,
   ];

   try {
       $pdo = new PDO($dsn, $user, $pass, $options);
      } catch (PDOException $e) {
    die('Conexión fallida: ' . $e->getMessage());
      }
   ?>

4. **Inicia el servidor web: Si estás utilizando el servidor integrado de PHP, puedes iniciar el servidor con el siguiente comando:**
   ```bash
   php -S localhost:8000 -t public

   
   
