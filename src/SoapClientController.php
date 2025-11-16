<?php
/**
 * Controlador del Cliente SOAP
 * 
 * Gestiona la comunicación con el servidor SOAP
 * Proporciona métodos para consumir cada operación
 */

class SoapClientController {
    
    private $client;
    private $error = null;

    public function __construct() {
        try {
            $this->client = new SoapClient(SOAP_SERVER_URL, array(
                'trace' => 1,
                'exceptions' => true
            ));
        } catch (SoapFault $e) {
            $this->error = "Error conectando con servidor SOAP: " . $e->getMessage();
            error_log($this->error);
        }
    }

    /**
     * Registrar un nuevo paciente
     */
    public function registrar($cedula, $nombres, $apellidos, $telefono, $fechaNacimiento) {
        if (!$this->client) return false;
        
        try {
            $resultado = $this->client->registrarPaciente(
                $cedula, $nombres, $apellidos, $telefono, $fechaNacimiento
            );
            return $resultado;
        } catch (SoapFault $e) {
            $this->error = "Error al registrar: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Buscar paciente por cédula
     */
    public function buscar($cedula) {
        if (!$this->client) return null;
        
        try {
            $resultado = $this->client->buscarPaciente($cedula);
            return $resultado;
        } catch (SoapFault $e) {
            $this->error = "Error al buscar: " . $e->getMessage();
            return null;
        }
    }

    /**
     * Listar todos los pacientes
     */
    public function listar() {
        if (!$this->client) return array();
        
        try {
            $resultado = $this->client->listarPacientes();
            return isset($resultado->return->paciente) ? $resultado->return->paciente : array();
        } catch (SoapFault $e) {
            $this->error = "Error al listar: " . $e->getMessage();
            return array();
        }
    }

    /**
     * Actualizar datos de paciente
     */
    public function actualizar($cedula, $nombres, $apellidos, $telefono, $fechaNacimiento) {
        if (!$this->client) return false;
        
        try {
            $resultado = $this->client->actualizarPaciente(
                $cedula, $nombres, $apellidos, $telefono, $fechaNacimiento
            );
            return $resultado;
        } catch (SoapFault $e) {
            $this->error = "Error al actualizar: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Eliminar un paciente
     */
    public function eliminar($cedula) {
        if (!$this->client) return false;
        
        try {
            $resultado = $this->client->eliminarPaciente($cedula);
            return $resultado;
        } catch (SoapFault $e) {
            $this->error = "Error al eliminar: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Obtener el último error
     */
    public function getError() {
        return $this->error;
    }

    /**
     * Limpiar el error
     */
    public function clearError() {
        $this->error = null;
    }
}
?>
