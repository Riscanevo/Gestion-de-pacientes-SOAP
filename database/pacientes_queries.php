<?php
// ============================================
// GINPAC-SOAP: Funciones de Base de Datos
// ============================================

class PacientesDB {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // CREAR - Registrar nuevo paciente
    public function registrarPaciente($cedula, $nombres, $apellidos, $edad, $sexo, $telefono, $correo, $direccion, $fecha_nacimiento, $estado_cita = 'Pendiente') {
        // Verificar que no exista
        $stmt = $this->conexion->prepare("SELECT cedula FROM pacientes WHERE cedula = ?");
        $stmt->bind_param("s", $cedula);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            return ['exito' => false, 'mensaje' => 'La cédula ya existe'];
        }

        // Insertar nuevo paciente
        $stmt = $this->conexion->prepare(
            "INSERT INTO pacientes (cedula, nombres, apellidos, edad, sexo, telefono, correo, direccion, fecha_nacimiento, estado_cita) 
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("sssissssss", $cedula, $nombres, $apellidos, $edad, $sexo, $telefono, $correo, $direccion, $fecha_nacimiento, $estado_cita);
        
        if ($stmt->execute()) {
            $this->registrarAuditoria('CREAR', 'pacientes', $cedula, 'Sistema', "Nuevo paciente registrado: $nombres $apellidos");
            return ['exito' => true, 'mensaje' => 'Paciente registrado correctamente', 'id' => $this->conexion->insert_id];
        } else {
            return ['exito' => false, 'mensaje' => 'Error al registrar: ' . $stmt->error];
        }
    }

    // LEER - Buscar paciente por cédula
    public function buscarPaciente($cedula) {
        $stmt = $this->conexion->prepare("SELECT * FROM pacientes WHERE cedula = ?");
        $stmt->bind_param("s", $cedula);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            return $resultado->fetch_assoc();
        } else {
            return null;
        }
    }

    // LEER - Listar todos los pacientes
    public function listarPacientes($orden = 'fecha_registro DESC') {
        $sql = "SELECT * FROM pacientes ORDER BY $orden";
        $resultado = $this->conexion->query($sql);

        $pacientes = [];
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $pacientes[] = $fila;
            }
        }
        return $pacientes;
    }

    // ACTUALIZAR - Modificar paciente
    public function actualizarPaciente($cedula, $nombres, $apellidos, $edad, $sexo, $telefono, $correo, $direccion, $fecha_nacimiento, $estado_cita) {
        // Verificar que existe
        if (!$this->buscarPaciente($cedula)) {
            return ['exito' => false, 'mensaje' => 'Paciente no encontrado'];
        }

        $stmt = $this->conexion->prepare(
            "UPDATE pacientes SET nombres = ?, apellidos = ?, edad = ?, sexo = ?, telefono = ?, correo = ?, direccion = ?, fecha_nacimiento = ?, estado_cita = ? 
             WHERE cedula = ?"
        );
        $stmt->bind_param("sssissssss", $nombres, $apellidos, $edad, $sexo, $telefono, $correo, $direccion, $fecha_nacimiento, $estado_cita, $cedula);
        
        if ($stmt->execute()) {
            $this->registrarAuditoria('ACTUALIZAR', 'pacientes', $cedula, 'Sistema', "Paciente actualizado: $nombres $apellidos");
            return ['exito' => true, 'mensaje' => 'Paciente actualizado correctamente'];
        } else {
            return ['exito' => false, 'mensaje' => 'Error al actualizar: ' . $stmt->error];
        }
    }

    // ELIMINAR - Borrar paciente
    public function eliminarPaciente($cedula) {
        // Verificar que existe
        $paciente = $this->buscarPaciente($cedula);
        if (!$paciente) {
            return ['exito' => false, 'mensaje' => 'Paciente no encontrado'];
        }

        $stmt = $this->conexion->prepare("DELETE FROM pacientes WHERE cedula = ?");
        $stmt->bind_param("s", $cedula);
        
        if ($stmt->execute()) {
            $this->registrarAuditoria('ELIMINAR', 'pacientes', $cedula, 'Sistema', "Paciente eliminado: {$paciente['nombres']} {$paciente['apellidos']}");
            return ['exito' => true, 'mensaje' => 'Paciente eliminado correctamente'];
        } else {
            return ['exito' => false, 'mensaje' => 'Error al eliminar: ' . $stmt->error];
        }
    }

    // Registrar en auditoría
    private function registrarAuditoria($accion, $tabla, $cedula, $usuario, $detalles) {
        $stmt = $this->conexion->prepare("INSERT INTO auditoria (accion, tabla_afectada, cedula_paciente, usuario, detalles) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $accion, $tabla, $cedula, $usuario, $detalles);
        $stmt->execute();
    }
}
?>
