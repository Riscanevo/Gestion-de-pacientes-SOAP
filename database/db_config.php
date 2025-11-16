<?php
// ============================================
// GINPAC-SOAP: Configuración de Base de Datos
// ============================================

// Configuración de conexión MySQL
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', ''); // Cambiar si tiene contraseña
define('DB_NAME', 'ginpac_soap');
define('DB_PORT', 3306);

// Crear conexión MySQLi
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

// Verificar conexión
if ($conexion->connect_error) {
    die('Error de conexión a la base de datos: ' . $conexion->connect_error);
}

// Establecer charset UTF-8
$conexion->set_charset("utf8mb4");

// Variable global para usar en todo el proyecto
$GLOBALS['db_connection'] = $conexion;
?>
