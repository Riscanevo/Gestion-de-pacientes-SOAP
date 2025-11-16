<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GINPAC-SOAP - Gestor de Pacientes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --color-primary: #16a34a;
            --color-primary-dark: #15803d;
            --color-primary-light: #86efac;
            --color-secondary: #0891b2;
            --color-bg: #f8fafc;
            --color-card: #ffffff;
            --color-text: #1e293b;
            --color-text-light: #64748b;
            --color-border: #e2e8f0;
        }

        body {
            background-color: var(--color-bg);
            color: var(--color-text);
        }

        .btn-primary {
            background-color: var(--color-primary);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: var(--color-primary-dark);
        }

        .card {
            background-color: var(--color-card);
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }

        .header {
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
            color: white;
            padding: 2rem;
            border-radius: 0 0 1rem 1rem;
        }
    </style>
</head>
<body class="bg-slate-50">
    <!-- Header -->
    <div class="header mb-8">
        <div class="max-w-6xl mx-auto">
            <h1 class="text-4xl font-bold mb-2">GINPAC-SOAP</h1>
            <p class="text-slate-100">Gestor Interno de Pacientes - Clínica SaludTotal</p>
        </div>
    </div>

    <!-- Contenido Principal -->
    <div class="max-w-6xl mx-auto px-4 pb-8">
        <!-- Alerta de Bienvenida -->
        <div class="card mb-8 bg-gradient-to-r from-green-50 to-cyan-50 border border-green-200">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Bienvenido al Sistema</h2>
            <p class="text-gray-700 mb-4">
                Este es el gestor de pacientes de la Clínica SaludTotal. Desde aquí puede gestionar 
                completamente la información de los pacientes registrados en el sistema.
            </p>
            <p class="text-sm text-gray-600">
                Seleccione una opción del menú para comenzar.
            </p>
        </div>

        <!-- Grid de Opciones -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Opción: Registrar Paciente -->
            <div class="card hover:shadow-lg transition-shadow">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Registrar Paciente</h3>
                </div>
                <p class="text-gray-600 mb-4">Agregue un nuevo paciente al sistema con sus datos personales.</p>
                <a href="?view=crear_paciente" class="btn-primary inline-block">Registrar Nuevo</a>
            </div>

            <!-- Opción: Ver Pacientes -->
            <div class="card hover:shadow-lg transition-shadow">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-cyan-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Ver Pacientes</h3>
                </div>
                <p class="text-gray-600 mb-4">Visualice la lista completa de pacientes registrados en el sistema.</p>
                <a href="?view=listar_pacientes" class="btn-primary inline-block">Ver Lista</a>
            </div>
        </div>

        <!-- Información del Sistema -->
        <div class="card border border-slate-200">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Información del Sistema</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div>
                    <p class="text-gray-600 font-semibold">Versión</p>
                    <p class="text-gray-800"><?php echo APP_VERSION; ?></p>
                </div>
                <div>
                    <p class="text-gray-600 font-semibold">Archivo de Datos</p>
                    <p class="text-gray-800 truncate"><?php echo PACIENTES_XML; ?></p>
                </div>
                <div>
                    <p class="text-gray-600 font-semibold">Arquitectura</p>
                    <p class="text-gray-800">SOAP/XML</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
