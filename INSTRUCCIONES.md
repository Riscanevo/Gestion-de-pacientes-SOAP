# Instrucciones para Ejecutar GINPAC-SOAP

## Pasos para empezar

### 1. Verificar que Node.js está instalado

Abre una terminal y ejecuta:
\`\`\`bash
node --version
npm --version
\`\`\`

Deberías ver versiones como: v14.0.0 o superior.

### 2. Descargar el proyecto

Si lo descargaste como ZIP, extrae la carpeta en tu computadora.

### 3. Navegar a la carpeta del proyecto

\`\`\`bash
cd ruta/a/ginpac-soap
\`\`\`

### 4. Instalar las dependencias

\`\`\`bash
npm install
\`\`\`

Espera a que se instalen todas las librerías (puede tardar 1-2 minutos).

### 5. Inicializar los datos (Opcional)

Para cargar datos de ejemplo:

\`\`\`bash
npm run init
\`\`\`

Esto cargará 3 pacientes de ejemplo en la base de datos.

### 6. Ejecutar el servidor

\`\`\`bash
npm start
\`\`\`

Deberías ver en la consola:

\`\`\`
╔════════════════════════════════════════╗
║     GINPAC - SOAP Servidor Activo      ║
╚════════════════════════════════════════╝

🌐 Aplicación Web: http://localhost:3000
📋 WSDL SOAP: http://localhost:3000/soap?wsdl

✓ Servicio SOAP publicado correctamente
\`\`\`

### 7. Abrir en el navegador

Abre tu navegador web (Chrome, Firefox, etc.) y ve a:

\`\`\`
http://localhost:3000
\`\`\`

## Funciones Disponibles

**Desde el Dashboard puedes:**

1. **Registrar Paciente** - Agregar nuevo paciente al sistema
2. **Ver Pacientes** - Ver tabla con todos los pacientes
3. **Editar** - Modificar datos de un paciente
4. **Eliminar** - Borrar un paciente

## Para Detener el Servidor

En la terminal donde está corriendo, presiona: `Ctrl + C`

## Solución de Problemas

### Error: "npm: comando no encontrado"
- Node.js no está instalado. Descárgalo de https://nodejs.org/

### Error: "Port 3000 already in use"
- El puerto ya está en uso. Cambia en server.js: `const PORT = 3001;`

### No ves nada en http://localhost:3000
- Verifica que el servidor está corriendo en la terminal
- Recarga la página (Ctrl + R o Cmd + R)

## Estructura de Archivos Importante

\`\`\`
ginpac-soap/
├── server.js                 ← Servidor principal
├── package.json              ← Dependencias
├── services/
│   └── PacientesService.js   ← Lógica SOAP
├── public/
│   ├── index.html            ← Página principal
│   ├── crear.html
│   ├── listar.html
│   ├── editar.html
│   └── styles.css
├── wsdl/
│   └── pacientes.wsdl        ← Definición WSDL
└── data/
    └── pacientes.xml         ← Base de datos
\`\`\`

## URLs Importantes

| URL | Descripción |
|-----|------------|
| http://localhost:3000 | Aplicación Web |
| http://localhost:3000/crear | Registrar paciente |
| http://localhost:3000/listar | Ver todos |
| http://localhost:3000/soap?wsdl | WSDL SOAP |

¡Listo! Tu sistema está funcionando.
