<?php
/**
 * GINPAC-SOAP - Servidor SOAP
 * 
 * Implementa el servicio web SOAP con operaciones CRUD para gestionar pacientes.
 * Publica el WSDL y expone las operaciones definidas.
 */

require_once 'config.php';
require_once 'src/PacientesService.php';

// Definir la URL base (importante para WSDL)
$baseURL = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
define('WSDL_URL', $baseURL . '/pacientes.wsdl');

// Crear instancia del servicio
$server = new SoapServer('pacientes.wsdl', array(
    'uri' => WSDL_URL,
    'encoding' => 'UTF-8'
));

// Registrar la clase de servicios
$server->setClass('PacientesService');

// Iniciar manejo de requests
$server->handle();
?>
