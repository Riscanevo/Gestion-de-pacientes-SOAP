<?php
/**
 * Configuración del Proyecto GINPAC-SOAP
 */

// Configuraciones de la aplicación
define('APP_NAME', 'GINPAC-SOAP');
define('APP_VERSION', '1.0.0');

// URL del servidor SOAP
define('SOAP_SERVER_URL', 'http://localhost:8000/soap_server.php?wsdl');

// Rutas del proyecto
define('BASE_PATH', __DIR__);
define('DATA_PATH', BASE_PATH . '/data');
define('VIEWS_PATH', BASE_PATH . '/views');

// Crear directorio de datos si no existe
if (!is_dir(DATA_PATH)) {
    mkdir(DATA_PATH, 0755, true);
}

// Archivo XML de persistencia
define('PACIENTES_XML', DATA_PATH . '/pacientes.xml');

// Encoding
header('Content-Type: text/html; charset=utf-8');
?>
