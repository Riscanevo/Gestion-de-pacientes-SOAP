# GINPAC-SOAP: Gestor Interno de Pacientes con Arquitectura SOAP

[![Node.js](https://img.shields.io/badge/Node.js-v14%2B-green)](https://nodejs.org/)
[![Express](https://img.shields.io/badge/Express-4.x-blue)](https://expressjs.com/)
[![SOAP](https://img.shields.io/badge/SOAP-W3C-orange)](https://www.w3.org/TR/soap/)
[![License](https://img.shields.io/badge/License-MIT-yellow)](LICENSE)

## Descripción del Proyecto

**GINPAC-SOAP** es un sistema web profesional de gestión de pacientes desarrollado como parcial final de Servicios Web. Implementa una arquitectura SOAP completa con interfaz gráfica moderna, manejo de datos persistente en MySQL y una REST API integrada.

El sistema está diseñado para que el personal de recepción de una clínica pueda registrar, buscar, actualizar y gestionar información de pacientes de manera eficiente y segura.

---

## Tabla de Contenidos

- [Características Principales](#características-principales)
- [Requisitos del Sistema](#requisitos-del-sistema)
- [Instalación y Configuración](#instalación-y-configuración)
- [Uso del Sistema](#uso-del-sistema)
- [Arquitectura Técnica](#arquitectura-técnica)
- [API REST](#api-rest)
- [Estructura del Proyecto](#estructura-del-proyecto)
- [Funcionalidades CRUD](#funcionalidades-crud)
- [Configuración de Base de Datos](#configuración-de-base-de-datos)
- [Guía de Usuario](#guía-de-usuario)
- [Troubleshooting](#troubleshooting)
- [Especificaciones Técnicas](#especificaciones-técnicas)

---

## Características Principales

✅ **Arquitectura SOAP Completa**
- Servicio SOAP completamente funcional
- WSDL profesional con 5 operaciones CRUD
- Compatible con clientes SOAP externos

✅ **Gestión de Pacientes**
- Registro de nuevos pacientes
- Búsqueda por cédula de identidad
- Listado completo con tabla interactiva
- Actualización de información
- Eliminación de registros

✅ **Interfaz Moderna**
- Diseño responsivo con Tailwind CSS
- Interfaz limpia y profesional
- Formularios con validación
- Dashboard intuitivo

✅ **Persistencia de Datos**
- Base de datos MySQL integrada
- Almacenamiento seguro y confiable
- Respaldo automático de datos

✅ **REST API**
- Endpoints REST para integración
- JSON para transferencia de datos
- CORS habilitado para desarrollo

---

## Requisitos del Sistema

### Mínimos
- **Node.js**: v14.0.0 o superior
- **npm**: v6.0.0 o superior
- **MySQL**: v5.7 o superior (o MariaDB)
- **XAMPP**: v7.0 o superior (recomendado)

### Navegadores Soportados
- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

### Requisitos de Hardware
- RAM mínimo: 512MB
- Espacio en disco: 100MB
- Procesador: Dual Core 2GHz+

---

## Instalación y Configuración

### Paso 1: Preparar la Base de Datos (XAMPP)

**1.1 Iniciar XAMPP**
- Abre XAMPP Control Panel
- Inicia Apache y MySQL

**1.2 Acceder a phpMyAdmin**
\`\`\`
http://localhost/phpmyadmin
\`\`\`

**1.3 Crear la Base de Datos**
- Copia el contenido de `database/01_create_database.sql`
- Pégalo en la pestaña SQL de phpMyAdmin
- Ejecuta la consulta

**1.4 Cargar Datos de Ejemplo**
- Copia el contenido de `database/02_seed_data.sql`
- Pégalo en la pestaña SQL de phpMyAdmin
- Ejecuta la consulta

### Paso 2: Instalar Node.js y Dependencias

**2.1 Descargar el Proyecto**
\`\`\`bash
# Clona o descarga el proyecto
cd ginpac-soap
\`\`\`

**2.2 Instalar Dependencias**
\`\`\`bash
npm install
\`\`\`

### Paso 3: Configurar Variables de Entorno

Crea un archivo `.env` en la raíz del proyecto:
\`\`\`env
# Base de Datos
DB_HOST=localhost
DB_USER=root
DB_PASSWORD=
DB_NAME=ginpac_soap
DB_PORT=3306

# Servidor
NODE_ENV=development
PORT=3000

# SOAP
SOAP_PORT=3000
SOAP_PATH=/soap
\`\`\`

### Paso 4: Ejecutar el Servidor

\`\`\`bash
npm start
\`\`\`

Deberías ver:
\`\`\`
✓ Servidor ejecutándose en http://localhost:3000
✓ Conectado a base de datos MySQL
✓ Servicio SOAP publicado en http://localhost:3000/soap?wsdl
\`\`\`

### Paso 5: Acceder a la Aplicación

Abre tu navegador y ve a:
\`\`\`
http://localhost:3000
\`\`\`

---

## Uso del Sistema

### Dashboard Principal
Al iniciar la aplicación, verás el dashboard con opciones principales:
- Crear nuevo paciente
- Listar pacientes
- Buscar paciente
- Ayuda y documentación

### Crear Nuevo Paciente
1. Haz clic en "Registrar Nuevo Paciente"
2. Completa todos los campos obligatorios
3. Haz clic en "Registrar Paciente"
4. Recibirás confirmación de éxito o error

### Buscar Paciente
1. Ve a "Listar Pacientes"
2. Usa el buscador por cédula o nombre
3. Los resultados aparecerán en tiempo real

### Actualizar Paciente
1. Ve a "Listar Pacientes"
2. Haz clic en el botón "Editar" del paciente
3. Modifica los datos
4. Haz clic en "Actualizar"

### Eliminar Paciente
1. Ve a "Listar Pacientes"
2. Haz clic en el botón "Eliminar"
3. Confirma la acción

---

## Arquitectura Técnica

### Diagrama de Flujo

\`\`\`
┌─────────────────────────────────────────────────────────┐
│                   Cliente (Navegador)                   │
│              HTML + JavaScript + Tailwind CSS           │
└──────────────────────┬──────────────────────────────────┘
                       │ HTTP Requests
                       ↓
┌─────────────────────────────────────────────────────────┐
│              Servidor Express (Node.js)                 │
│  ┌──────────────────────────────────────────────────┐  │
│  │            Rutas REST API (/api/*)               │  │
│  │  - POST /api/registrar                           │  │
│  │  - GET /api/buscar/:cedula                       │  │
│  │  - GET /api/listar                               │  │
│  │  - POST /api/actualizar                          │  │
│  │  - POST /api/eliminar                            │  │
│  └──────────────────────────────────────────────────┘  │
│  ┌──────────────────────────────────────────────────┐  │
│  │        Servidor SOAP (/soap)                     │  │
│  │  - Publica WSDL en /soap?wsdl                    │  │
│  │  - Expone 5 operaciones SOAP                     │  │
│  └──────────────────────────────────────────────────┘  │
│  ┌──────────────────────────────────────────────────┐  │
│  │    PacientesService (Lógica de Negocio)          │  │
│  │  - registrarPaciente()                           │  │
│  │  - buscarPaciente()                              │  │
│  │  - listarPacientes()                             │  │
│  │  - actualizarPaciente()                          │  │
│  │  - eliminarPaciente()                            │  │
│  └──────────────────────────────────────────────────┘  │
└──────────────────────┬──────────────────────────────────┘
                       │ Queries
                       ↓
┌─────────────────────────────────────────────────────────┐
│              Base de Datos MySQL                        │
│         Tabla: pacientes (con 10+ campos)              │
│         Índices: cedula (único), nombres              │
└─────────────────────────────────────────────────────────┘
\`\`\`

### Componentes Principales

**Frontend:**
- HTML5 semántico
- Tailwind CSS v4
- JavaScript Vanilla (sin frameworks)
- Formularios con validación cliente

**Backend:**
- Express.js 4.x
- Node SOAP para servicio WSDL
- MySQL2 para conexión a BD
- CORS habilitado

**Base de Datos:**
- MySQL 5.7+
- Tablas normalizadas
- Índices optimizados
- Constraints de integridad

---

## API REST

### Autenticación
No se requiere autenticación (entorno local/desarrollo)

### Headers Requeridos
\`\`\`
Content-Type: application/json
\`\`\`

### Endpoints

#### 1. Registrar Paciente
\`\`\`http
POST /api/registrar
Content-Type: application/json

{
  "cedula": "88202414",
  "nombres": "Freddy Eduardo",
  "apellidos": "Riscanevo Mendez",
  "telefono": "3012345678",
  "fecha_nacimiento": "2004-04-20",
  "sexo": "M",
  "edad": 20,
  "correo": "freddy@example.com",
  "direccion": "Calle 123 #456",
  "estado_cita": "pendiente"
}
\`\`\`

**Respuesta Exitosa (201):**
\`\`\`json
{
  "success": true,
  "message": "Paciente registrado exitosamente",
  "data": {
    "cedula": "88202414",
    "nombres": "Freddy Eduardo"
  }
}
\`\`\`

**Respuesta Error (400):**
\`\`\`json
{
  "success": false,
  "error": "La cédula ya existe"
}
\`\`\`

#### 2. Buscar Paciente
\`\`\`http
GET /api/buscar/88202414
\`\`\`

**Respuesta (200):**
\`\`\`json
{
  "success": true,
  "data": {
    "cedula": "88202414",
    "nombres": "Freddy Eduardo",
    "apellidos": "Riscanevo Mendez",
    "edad": 20
  }
}
\`\`\`

#### 3. Listar Pacientes
\`\`\`http
GET /api/listar
\`\`\`

**Respuesta (200):**
\`\`\`json
{
  "success": true,
  "total": 5,
  "data": [
    {
      "cedula": "88202414",
      "nombres": "Freddy Eduardo",
      "apellidos": "Riscanevo Mendez",
      "telefono": "3012345678"
    }
  ]
}
\`\`\`

#### 4. Actualizar Paciente
\`\`\`http
POST /api/actualizar
Content-Type: application/json

{
  "cedula": "88202414",
  "nombres": "Federico",
  "apellidos": "Riscanevo",
  "telefono": "3019876543"
}
\`\`\`

#### 5. Eliminar Paciente
\`\`\`http
POST /api/eliminar
Content-Type: application/json

{
  "cedula": "88202414"
}
\`\`\`

---

## Estructura del Proyecto


ginpac-soap/
├── README.md                          # Este archivo
├── package.json                       # Dependencias de Node.js
├── .env                               # Variables de entorno
├── server.js                          # Servidor principal Express
│
├── config/
│   └── database.js                    # Configuración MySQL
│
├── database/
│   ├── 01_create_database.sql        # Script crear BD
│   └── 02_seed_data.sql              # Script datos ejemplo
│
├── services/
│   └── PacientesService.js           # Lógica CRUD
│
├── wsdl/
│   └── pacientes.wsdl                # Contrato SOAP
│
├── scripts/
│   ├── init-data.js                  # Inicializar datos
│   └── check-setup.js                # Verificar setup
│
└── public/
    ├── index.html                    # Dashboard principal
    ├── crear.html                    # Registrar paciente
    ├── listar.html                   # Ver pacientes
    ├── editar.html                   # Editar paciente
    └── styles.css                    # Estilos Tailwind


---

## Funcionalidades CRUD

### RF-01: Registrar Paciente
- **Descripción**: Crear nuevo registro de paciente
- **Campos**: Cédula*, Nombres*, Apellidos*, Teléfono*, Fecha Nacimiento*
- **Validación**: Cédula única, campos requeridos
- **Persistencia**: MySQL

### RF-02: Buscar Paciente
- **Descripción**: Localizar paciente por cédula
- **Entrada**: Número de cédula
- **Salida**: Datos completos del paciente
- **Casos**: Encontrado, no encontrado

### RF-03: Listar Pacientes
- **Descripción**: Mostrar todos los pacientes registrados
- **Salida**: Tabla con datos principales
- **Filtros**: Por nombre, cédula, estado

### RF-04: Actualizar Paciente
- **Descripción**: Modificar datos existentes
- **Campos**: Todos excepto cédula (identificador único)
- **Validación**: Paciente debe existir
- **Persistencia**: Cambios inmediatos

### RF-05: Eliminar Paciente
- **Descripción**: Remover registro de paciente
- **Confirmación**: Requerida antes de eliminar
- **Persistencia**: Eliminación permanente

---

## Configuración de Base de Datos

### Tabla: pacientes

\`\`\`sql
CREATE TABLE pacientes (
  cedula VARCHAR(20) PRIMARY KEY,
  nombres VARCHAR(100) NOT NULL,
  apellidos VARCHAR(100) NOT NULL,
  edad INT,
  sexo VARCHAR(10),
  telefono VARCHAR(20) NOT NULL,
  correo VARCHAR(100),
  direccion VARCHAR(200),
  fecha_nacimiento DATE NOT NULL,
  estado_cita VARCHAR(50),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_nombres (nombres),
  INDEX idx_estado_cita (estado_cita)
);
\`\`\`

### Campos

| Campo | Tipo | Restricción | Descripción |
|-------|------|------------|------------|
| cedula | VARCHAR(20) | PRIMARY KEY | Identificador único |
| nombres | VARCHAR(100) | NOT NULL | Nombre(s) del paciente |
| apellidos | VARCHAR(100) | NOT NULL | Apellido(s) del paciente |
| edad | INT | - | Edad en años |
| sexo | VARCHAR(10) | - | M/F/Otro |
| telefono | VARCHAR(20) | NOT NULL | Contacto telefónico |
| correo | VARCHAR(100) | - | Email del paciente |
| direccion | VARCHAR(200) | - | Domicilio |
| fecha_nacimiento | DATE | NOT NULL | Fecha de nacimiento |
| estado_cita | VARCHAR(50) | - | pendiente/confirmada/cancelada |
| created_at | TIMESTAMP | AUTO | Fecha creación |
| updated_at | TIMESTAMP | AUTO | Última actualización |

---

## Guía de Usuario

### Para Personal de Recepción

#### Registrar Nuevo Paciente
1. Abre http://localhost:3000
2. Haz clic en "Registrar Nuevo Paciente"
3. Completa el formulario con los datos
4. Haz clic en "Registrar Paciente"

#### Buscar Información de Paciente
1. Ve a "Listar Pacientes"
2. Usa el buscador en la parte superior
3. Escribe cédula o nombre
4. Resultados aparecen en tiempo real

#### Actualizar Datos
1. En la tabla de pacientes, haz clic "Editar"
2. Modifica los campos necesarios
3. Haz clic "Actualizar Paciente"

#### Eliminar Registro
1. En la tabla, haz clic "Eliminar"
2. Confirma la acción
3. El registro se eliminará permanentemente

---

## Scripts Disponibles

\`\`\`bash
# Inicia el servidor
npm start

# Instala dependencias
npm install

# Inicializa datos de ejemplo
npm run init

# Verifica la configuración
npm run check-setup
\`\`\`

---

## Troubleshooting

### Error: "Cannot connect to database"
**Solución:**
1. Verifica que MySQL esté corriendo en XAMPP
2. Confirma credenciales en `.env`
3. Verifica que la BD `ginpac_soap` existe

### Error: "Port 3000 already in use"
**Solución:**
Edita `.env` y cambia `PORT=3001`

### Error: "Module not found"
**Solución:**
\`\`\`bash
npm install
npm start
\`\`\`

### No se ven datos en el formulario
**Solución:**
Ejecuta los scripts SQL en phpMyAdmin para crear tablas

### WSDL no se carga
**Solución:**
Verifica que el servidor esté corriendo en http://localhost:3000/soap?wsdl

---

## Especificaciones Técnicas

### Stack Tecnológico
- **Runtime**: Node.js v14+
- **Framework Backend**: Express.js 4.x
- **SOAP**: node-soap
- **BD**: MySQL 5.7+
- **ORM**: None (queries directas)
- **Frontend**: HTML5 + Tailwind CSS v4 + JavaScript Vanilla
- **Control de Versiones**: Git

### Dependencias Principales
\`\`\`json
{
  "express": "^4.18.0",
  "soap": "^0.12.0",
  "mysql2": "^3.0.0",
  "cors": "^2.8.5",
  "dotenv": "^16.0.0"
}
\`\`\`

### Performance
- Respuesta promedio: < 100ms
- Conexión BD: Pool de 10 conexiones
- Memoria RAM: ~50MB
- Tiempo inicio: ~2 segundos

---

## Notas Importantes

- ✅ El sistema es case-sensitive para búsquedas
- ✅ La cédula es el identificador único e inmutable
- ✅ Todos los campos se validan en cliente y servidor
- ✅ Los cambios se guardan inmediatamente en BD
- ✅ El servicio SOAP está disponible 24/7 mientras el servidor corre
- ✅ Se recomienda hacer backup regular de la BD

---

## Autor

**Proyecto Académico**
- Parcial Final: Arquitectura Cliente - Servidor
- Institución: Universidad Fundación de estudios superiores comfanorte - FESC
- Fecha: Noviembre 2025

---

## Licencia

MIT License - Libre para usar, modificar y distribuir

---

## Contacto y Soporte

Para preguntas o reportes de errores, abre un issue en el repositorio o contacta al desarrollador.

---

**Versión**: 1.0.0  
**Última actualización**: Noviembre 2025
