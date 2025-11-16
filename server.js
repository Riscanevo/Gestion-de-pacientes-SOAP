const express = require('express');
const soap = require('soap');
const fs = require('fs');
const path = require('path');
const cors = require('cors');

const app = express();
const PORT = 3001;

// Middleware
app.use(cors());
app.use(express.json());
app.use(express.urlencoded({ extended: true }));
app.use(express.static('public'));

// Importar servicio de pacientes
const PacientesService = require('./services/PacientesService');

// Rutas para vistas (RF-06, RF-07, RF-08, RF-09)
app.get('/', (req, res) => {
  res.sendFile(path.join(__dirname, 'public', 'index.html'));
});

app.get('/crear', (req, res) => {
  res.sendFile(path.join(__dirname, 'public', 'crear.html'));
});

app.get('/listar', (req, res) => {
  res.sendFile(path.join(__dirname, 'public', 'listar.html'));
});

app.get('/editar/:cedula', (req, res) => {
  res.sendFile(path.join(__dirname, 'public', 'editar.html'));
});

// RF-01: Registrar Paciente
app.post('/api/registrar', (req, res) => {
  PacientesService.registrarPaciente({ paciente: req.body }, (err, result) => {
    if (err) {
      res.json({ exitoso: false, mensaje: err.message });
    } else {
      res.json(result.respuesta);
    }
  });
});

// RF-02: Buscar Paciente
app.get('/api/buscar/:cedula', (req, res) => {
  PacientesService.buscarPaciente({ cedula: req.params.cedula }, (err, result) => {
    if (err) {
      res.json({ exitoso: false, mensaje: err.message });
    } else {
      res.json(result.respuesta);
    }
  });
});

// RF-03: Listar Pacientes
app.get('/api/listar', (req, res) => {
  PacientesService.listarPacientes({}, (err, result) => {
    if (err) {
      res.json({ exitoso: false, mensaje: err.message });
    } else {
      res.json(result.respuesta);
    }
  });
});

// RF-04: Actualizar Paciente
app.post('/api/actualizar', (req, res) => {
  const { cedula, ...pacienteData } = req.body;
  PacientesService.actualizarPaciente({ cedula, paciente: pacienteData }, (err, result) => {
    if (err) {
      res.json({ exitoso: false, mensaje: err.message });
    } else {
      res.json(result.respuesta);
    }
  });
});

// RF-05: Eliminar Paciente
app.post('/api/eliminar', (req, res) => {
  PacientesService.eliminarPaciente({ cedula: req.body.cedula }, (err, result) => {
    if (err) {
      res.json({ exitoso: false, mensaje: err.message });
    } else {
      res.json(result.respuesta);
    }
  });
});

// Cargar WSDL y publicar servicio SOAP
const wsdlPath = path.join(__dirname, 'wsdl', 'pacientes.wsdl');

// Iniciar servidor HTTP y SOAP
const server = app.listen(PORT, async () => {
  console.log(`\n╔════════════════════════════════════════╗`);
  console.log(`║     GINPAC - SOAP Servidor Activo      ║`);
  console.log(`╚════════════════════════════════════════╝\n`);
  console.log(`🌐 Aplicación Web: http://localhost:${PORT}`);
  console.log(`📋 WSDL SOAP: http://localhost:${PORT}/soap?wsdl\n`);
  
  try {
    // Publicar servicio SOAP
    const xml = fs.readFileSync(wsdlPath, 'utf8');
    
    soap.listen(server, '/soap', {
      PacientesService: {
        PacientesPort: PacientesService
      }
    }, xml);
    
    console.log('✓ Servicio SOAP publicado correctamente\n');
  } catch (error) {
    console.error('Error al publicar SOAP:', error.message);
  }
});

module.exports = app;
