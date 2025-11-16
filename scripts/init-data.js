const fs = require('fs');
const path = require('path');
const xml2js = require('xml2js');

const dataDir = path.join(__dirname, '..', 'data');
const xmlFile = path.join(dataDir, 'pacientes.xml');

// Crear directorio si no existe
if (!fs.existsSync(dataDir)) {
  fs.mkdirSync(dataDir, { recursive: true });
}

// Datos iniciales de ejemplo
const datosIniciales = {
  pacientes: {
    paciente: [
      {
        cedula: ['1234567890'],
        nombres: ['Juan'],
        apellidos: ['Pérez'],
        telefono: ['3101234567'],
        fechaNacimiento: ['1990-05-15']
      },
      {
        cedula: ['0987654321'],
        nombres: ['María'],
        apellidos: ['González'],
        telefono: ['3109876543'],
        fechaNacimiento: ['1985-08-20']
      },
      {
        cedula: ['1122334455'],
        nombres: ['Carlos'],
        apellidos: ['Martínez'],
        telefono: ['3111234567'],
        fechaNacimiento: ['1992-12-03']
      }
    ]
  }
};

// Crear o actualizar XML
const builder = new xml2js.Builder();
const xml = builder.buildObject(datosIniciales);

fs.writeFileSync(xmlFile, xml);
console.log('Archivo XML inicializado en:', xmlFile);
