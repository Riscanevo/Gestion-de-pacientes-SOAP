<?php
/**
 * GINPAC-SOAP - Gestor Interno de Pacientes
 * Cliente Frontend - Punto de entrada principal
 * 
 * Este archivo actúa como cliente SOAP que consume los servicios
 * del servidor ubicado en soap_server.php
 */

// Incluir configuraciones y dependencias
require_once 'config.php';
require_once 'src/SoapClientController.php';

// Inicializar el controlador del cliente
$controller = new SoapClientController();

// Determinar la vista a mostrar
$view = isset($_GET['view']) ? $_GET['view'] : 'home';

// Incluir la vista correspondiente
$viewPath = "views/{$view}.php";

if (file_exists($viewPath)) {
    include $viewPath;
} else {
    include 'views/home.php';
}
?>
