const fs = require('fs');
const path = require('path');
const xml2js = require('xml2js');

const xmlFile = path.join(__dirname, '..', 'data', 'pacientes.xml');
const builder = new xml2js.Builder();
const parser = new xml2js.Parser();

// Garantizar que el archivo XML existe
function inicializarXML() {
  if (!fs.existsSync(xmlFile)) {
    const xmlContent = '<?xml version="1.0" encoding="UTF-8"?><pacientes></pacientes>';
    fs.writeFileSync(xmlFile, xmlContent);
  }
}

// Leer XML
async function leerXML() {
  inicializarXML();
  const data = fs.readFileSync(xmlFile, 'utf8');
  return await parser.parseStringPromise(data);
}

// Guardar XML
async function guardarXML(objeto) {
  const xml = builder.buildObject(objeto);
  fs.writeFileSync(xmlFile, xml);
}

// Servicios SOAP
const PacientesService = {
  // RF-01: Registrar Paciente
  registrarPaciente: async function(args, callback) {
    try {
      const pacienteData = args.paciente;
      const xmlData = await leerXML();
      
      // Verificar si cédula ya existe
      if (xmlData.pacientes.paciente) {
        const existe = xmlData.pacientes.paciente.some(p => p.cedula[0] === pacienteData.cedula);
        if (existe) {
          return callback(null, {
            respuesta: {
              exitoso: false,
              mensaje: 'La cédula ya existe en el sistema'
            }
          });
        }
      }
      
      // Agregar nuevo paciente
      if (!xmlData.pacientes.paciente) {
        xmlData.pacientes.paciente = [];
      }
      
      xmlData.pacientes.paciente.push({
        cedula: [pacienteData.cedula],
        nombres: [pacienteData.nombres],
        apellidos: [pacienteData.apellidos],
        telefono: [pacienteData.telefono],
        fechaNacimiento: [pacienteData.fechaNacimiento]
      });
      
      await guardarXML(xmlData);
      
      callback(null, {
        respuesta: {
          exitoso: true,
          mensaje: 'Paciente registrado exitosamente'
        }
      });
    } catch (error) {
      callback(null, {
        respuesta: {
          exitoso: false,
          mensaje: 'Error al registrar: ' + error.message
        }
      });
    }
  },

  // RF-02: Buscar Paciente por Cédula
  buscarPaciente: async function(args, callback) {
    try {
      const cedula = args.cedula;
      const xmlData = await leerXML();
      
      if (!xmlData.pacientes.paciente) {
        return callback(null, {
          respuesta: {
            exitoso: false,
            mensaje: 'No hay pacientes registrados'
          }
        });
      }
      
      const paciente = xmlData.pacientes.paciente.find(p => p.cedula[0] === cedula);
      
      if (!paciente) {
        return callback(null, {
          respuesta: {
            exitoso: false,
            mensaje: 'Paciente no encontrado'
          }
        });
      }
      
      callback(null, {
        respuesta: {
          exitoso: true,
          mensaje: 'Paciente encontrado',
          datos: {
            cedula: paciente.cedula[0],
            nombres: paciente.nombres[0],
            apellidos: paciente.apellidos[0],
            telefono: paciente.telefono[0],
            fechaNacimiento: paciente.fechaNacimiento[0]
          }
        }
      });
    } catch (error) {
      callback(null, {
        respuesta: {
          exitoso: false,
          mensaje: 'Error al buscar: ' + error.message
        }
      });
    }
  },

  // RF-03: Listar Todos los Pacientes
  listarPacientes: async function(args, callback) {
    try {
      const xmlData = await leerXML();
      
      if (!xmlData.pacientes.paciente || xmlData.pacientes.paciente.length === 0) {
        return callback(null, {
          respuesta: {
            exitoso: true,
            mensaje: 'Lista vacía',
            datos: []
          }
        });
      }
      
      const pacientes = xmlData.pacientes.paciente.map(p => ({
        cedula: p.cedula[0],
        nombres: p.nombres[0],
        apellidos: p.apellidos[0],
        telefono: p.telefono[0],
        fechaNacimiento: p.fechaNacimiento[0]
      }));
      
      callback(null, {
        respuesta: {
          exitoso: true,
          mensaje: 'Pacientes listados exitosamente',
          datos: pacientes
        }
      });
    } catch (error) {
      callback(null, {
        respuesta: {
          exitoso: false,
          mensaje: 'Error al listar: ' + error.message
        }
      });
    }
  },

  // RF-04: Actualizar Paciente
  actualizarPaciente: async function(args, callback) {
    try {
      const cedula = args.cedula;
      const pacienteData = args.paciente;
      const xmlData = await leerXML();
      
      if (!xmlData.pacientes.paciente) {
        return callback(null, {
          respuesta: {
            exitoso: false,
            mensaje: 'No hay pacientes registrados'
          }
        });
      }
      
      const paciente = xmlData.pacientes.paciente.find(p => p.cedula[0] === cedula);
      
      if (!paciente) {
        return callback(null, {
          respuesta: {
            exitoso: false,
            mensaje: 'Paciente no encontrado'
          }
        });
      }
      
      // Actualizar datos
      paciente.nombres = [pacienteData.nombres];
      paciente.apellidos = [pacienteData.apellidos];
      paciente.telefono = [pacienteData.telefono];
      paciente.fechaNacimiento = [pacienteData.fechaNacimiento];
      
      await guardarXML(xmlData);
      
      callback(null, {
        respuesta: {
          exitoso: true,
          mensaje: 'Paciente actualizado exitosamente'
        }
      });
    } catch (error) {
      callback(null, {
        respuesta: {
          exitoso: false,
          mensaje: 'Error al actualizar: ' + error.message
        }
      });
    }
  },

  // RF-05: Eliminar Paciente
  eliminarPaciente: async function(args, callback) {
    try {
      const cedula = args.cedula;
      const xmlData = await leerXML();
      
      if (!xmlData.pacientes.paciente) {
        return callback(null, {
          respuesta: {
            exitoso: false,
            mensaje: 'No hay pacientes registrados'
          }
        });
      }
      
      const index = xmlData.pacientes.paciente.findIndex(p => p.cedula[0] === cedula);
      
      if (index === -1) {
        return callback(null, {
          respuesta: {
            exitoso: false,
            mensaje: 'Paciente no encontrado'
          }
        });
      }
      
      xmlData.pacientes.paciente.splice(index, 1);
      await guardarXML(xmlData);
      
      callback(null, {
        respuesta: {
          exitoso: true,
          mensaje: 'Paciente eliminado exitosamente'
        }
      });
    } catch (error) {
      callback(null, {
        respuesta: {
          exitoso: false,
          mensaje: 'Error al eliminar: ' + error.message
        }
      });
    }
  }
};

module.exports = PacientesService;
