<?php
/**
 * Clase PacientesService
 * 
 * Implementa la lógica de negocio del servicio SOAP
 * Maneja todas las operaciones CRUD sobre el archivo pacientes.xml
 */

class PacientesService {
    
    private $xmlFile;
    private $dom;

    public function __construct() {
        $this->xmlFile = PACIENTES_XML;
        $this->inicializarXML();
    }

    /**
     * Inicializa el archivo XML si no existe
     */
    private function inicializarXML() {
        if (!file_exists($this->xmlFile)) {
            $xml = '<?xml version="1.0" encoding="UTF-8"?><pacientes></pacientes>';
            file_put_contents($this->xmlFile, $xml);
        }
    }

    /**
     * Carga el XML en memoria
     */
    private function cargarXML() {
        $this->dom = new DOMDocument();
        $this->dom->load($this->xmlFile);
        return $this->dom;
    }

    /**
     * Guarda los cambios en el XML
     */
    private function guardarXML() {
        $this->dom->save($this->xmlFile);
    }

    /**
     * RF-01: Registrar un nuevo paciente
     */
    public function registrarPaciente($cedula, $nombres, $apellidos, $telefono, $fechaNacimiento) {
        try {
            $this->cargarXML();
            
            // Validar que la cédula no exista
            $xpath = new DOMXPath($this->dom);
            $existe = $xpath->query("//paciente[cedula='$cedula']");
            
            if ($existe->length > 0) {
                return false; // Ya existe
            }

            // Crear nuevo nodo paciente
            $root = $this->dom->documentElement;
            $paciente = $this->dom->createElement('paciente');
            
            $paciente->appendChild($this->dom->createElement('cedula', $cedula));
            $paciente->appendChild($this->dom->createElement('nombres', $nombres));
            $paciente->appendChild($this->dom->createElement('apellidos', $apellidos));
            $paciente->appendChild($this->dom->createElement('telefono', $telefono));
            $paciente->appendChild($this->dom->createElement('fechaNacimiento', $fechaNacimiento));
            
            $root->appendChild($paciente);
            $this->guardarXML();
            
            return true;
        } catch (Exception $e) {
            error_log("Error al registrar paciente: " . $e->getMessage());
            return false;
        }
    }

    /**
     * RF-02: Buscar paciente por cédula
     */
    public function buscarPaciente($cedula) {
        try {
            $this->cargarXML();
            $xpath = new DOMXPath($this->dom);
            $resultado = $xpath->query("//paciente[cedula='$cedula']");
            
            if ($resultado->length == 0) {
                return null;
            }

            $paciente = $resultado->item(0);
            return array(
                'cedula' => $this->obtenerValor($paciente, 'cedula'),
                'nombres' => $this->obtenerValor($paciente, 'nombres'),
                'apellidos' => $this->obtenerValor($paciente, 'apellidos'),
                'telefono' => $this->obtenerValor($paciente, 'telefono'),
                'fechaNacimiento' => $this->obtenerValor($paciente, 'fechaNacimiento')
            );
        } catch (Exception $e) {
            error_log("Error al buscar paciente: " . $e->getMessage());
            return null;
        }
    }

    /**
     * RF-03: Listar todos los pacientes
     */
    public function listarPacientes() {
        try {
            $this->cargarXML();
            $pacientes = array();
            
            foreach ($this->dom->getElementsByTagName('paciente') as $paciente) {
                $pacientes[] = array(
                    'cedula' => $this->obtenerValor($paciente, 'cedula'),
                    'nombres' => $this->obtenerValor($paciente, 'nombres'),
                    'apellidos' => $this->obtenerValor($paciente, 'apellidos'),
                    'telefono' => $this->obtenerValor($paciente, 'telefono'),
                    'fechaNacimiento' => $this->obtenerValor($paciente, 'fechaNacimiento')
                );
            }
            
            return array('paciente' => $pacientes);
        } catch (Exception $e) {
            error_log("Error al listar pacientes: " . $e->getMessage());
            return array('paciente' => array());
        }
    }

    /**
     * RF-04: Actualizar datos de un paciente
     */
    public function actualizarPaciente($cedula, $nombres, $apellidos, $telefono, $fechaNacimiento) {
        try {
            $this->cargarXML();
            $xpath = new DOMXPath($this->dom);
            $resultado = $xpath->query("//paciente[cedula='$cedula']");
            
            if ($resultado->length == 0) {
                return false;
            }

            $paciente = $resultado->item(0);
            
            // Actualizar elementos
            $this->actualizarElemento($paciente, 'nombres', $nombres);
            $this->actualizarElemento($paciente, 'apellidos', $apellidos);
            $this->actualizarElemento($paciente, 'telefono', $telefono);
            $this->actualizarElemento($paciente, 'fechaNacimiento', $fechaNacimiento);
            
            $this->guardarXML();
            return true;
        } catch (Exception $e) {
            error_log("Error al actualizar paciente: " . $e->getMessage());
            return false;
        }
    }

    /**
     * RF-05: Eliminar un paciente
     */
    public function eliminarPaciente($cedula) {
        try {
            $this->cargarXML();
            $xpath = new DOMXPath($this->dom);
            $resultado = $xpath->query("//paciente[cedula='$cedula']");
            
            if ($resultado->length == 0) {
                return false;
            }

            $paciente = $resultado->item(0);
            $paciente->parentNode->removeChild($paciente);
            $this->guardarXML();
            
            return true;
        } catch (Exception $e) {
            error_log("Error al eliminar paciente: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Utilidad: Obtener valor de un elemento hijo
     */
    private function obtenerValor($nodo, $nombreElemento) {
        $elementos = $nodo->getElementsByTagName($nombreElemento);
        return $elementos->length > 0 ? $elementos->item(0)->nodeValue : '';
    }

    /**
     * Utilidad: Actualizar un elemento
     */
    private function actualizarElemento($nodo, $nombreElemento, $nuevoValor) {
        $elementos = $nodo->getElementsByTagName($nombreElemento);
        if ($elementos->length > 0) {
            $elementos->item(0)->nodeValue = $nuevoValor;
        }
    }
}
?>
