-- ============================================
-- GINPAC-SOAP: Datos de Ejemplo
-- ============================================

USE ginpac_soap;

-- Insertar datos de ejemplo
INSERT INTO pacientes (cedula, nombres, apellidos, edad, sexo, telefono, correo, direccion, fecha_nacimiento, estado_cita) VALUES
('1010123456', 'Juan', 'Pérez García', 35, 'M', '3001234567', 'juan.perez@email.com', 'Calle 10 #5-30', '1989-03-15', 'Pendiente'),
('1010234567', 'María', 'López Rodríguez', 28, 'F', '3009876543', 'maria.lopez@email.com', 'Carrera 7 #12-45', '1996-07-22', 'Completada'),
('1010345678', 'Carlos', 'Martínez Sánchez', 42, 'M', '3005555555', 'carlos.martinez@email.com', 'Avenida 5 #8-20', '1982-11-08', 'Pendiente'),
('1010456789', 'Ana', 'González Morales', 31, 'F', '3007777777', 'ana.gonzalez@email.com', 'Calle 20 #15-50', '1993-05-30', 'Cancelada'),
('1010567890', 'Roberto', 'Hernández López', 55, 'M', '3003333333', 'roberto.hernandez@email.com', 'Carrera 12 #9-35', '1970-01-12', 'Completada');
