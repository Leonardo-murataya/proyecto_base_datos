<?php
// importar sesión
session_start();

// destruir la sesión
session_destroy();

// redirigir al usuario a la página de inicio de sesión
header('Location: login.php');
exit();