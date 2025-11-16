const fs = require('fs');
const path = require('path');

console.log('\n╔════════════════════════════════════════╗');
console.log('║   GINPAC - Verificación del Setup      ║');
console.log('╚════════════════════════════════════════╝\n');

const checks = [
  {
    name: 'Archivo server.js',
    file: path.join(__dirname, '..', 'server.js')
  },
  {
    name: 'WSDL Pacientes',
    file: path.join(__dirname, '..', 'wsdl', 'pacientes.wsdl')
  },
  {
    name: 'Servicio SOAP',
    file: path.join(__dirname, '..', 'services', 'PacientesService.js')
  },
  {
    name: 'Home (index.html)',
    file: path.join(__dirname, '..', 'public', 'index.html')
  },
  {
    name: 'Crear Paciente (crear.html)',
    file: path.join(__dirname, '..', 'public', 'crear.html')
  },
  {
    name: 'Listar Pacientes (listar.html)',
    file: path.join(__dirname, '..', 'public', 'listar.html')
  },
  {
    name: 'Editar Paciente (editar.html)',
    file: path.join(__dirname, '..', 'public', 'editar.html')
  },
  {
    name: 'Estilos CSS',
    file: path.join(__dirname, '..', 'public', 'styles.css')
  }
];

let ok = 0;
let fail = 0;

checks.forEach(check => {
  if (fs.existsSync(check.file)) {
    console.log(`✓ ${check.name}`);
    ok++;
  } else {
    console.log(`✗ ${check.name} - NO ENCONTRADO`);
    fail++;
  }
});

console.log(`\n────────────────────────────────────────`);
console.log(`Verificación: ${ok}/${checks.length} archivos OK`);
console.log(`────────────────────────────────────────\n`);

if (fail === 0) {
  console.log('✓ Todo está listo. Ejecuta: npm start\n');
  process.exit(0);
} else {
  console.log(`✗ Faltan ${fail} archivos. Revisa la estructura del proyecto.\n`);
  process.exit(1);
}
