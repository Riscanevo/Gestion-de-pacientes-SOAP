<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Pacientes - GINPAC-SOAP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="bg-slate-50">
    <!-- Header -->
    <div class="bg-gradient-to-r from-green-600 to-cyan-600 text-white p-6 mb-8 rounded-b-lg">
        <div class="max-w-6xl mx-auto">
            <h1 class="text-3xl font-bold">Listado de Pacientes</h1>
            <p class="text-green-100">Visualice y gestione los pacientes registrados</p>
        </div>
    </div>

    <!-- Contenido -->
    <div class="max-w-6xl mx-auto px-4 pb-8">
        <?php
        $controller = new SoapClientController();
        $pacientes = $controller->listar();
        ?>

        <!-- Tabla de Pacientes -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <?php if (!empty($pacientes) && is_array($pacientes)): ?>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-blue-600 border-b border-blue-500">
                                <th class="px-6 py-3 text-left text-sm font-semibold text-white">Cédula</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-white">Nombres</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-white">Apellidos</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-white">Teléfono</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-white">Nacimiento</th>
                                <th class="px-6 py-3 text-center text-sm font-semibold text-white">Acciones</th>
                            </tr>

                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php foreach ($pacientes as $paciente): ?>
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-sm text-gray-800"><?php echo htmlspecialchars($paciente->cedula ?? ''); ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-800"><?php echo htmlspecialchars($paciente->nombres ?? ''); ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-800"><?php echo htmlspecialchars($paciente->apellidos ?? ''); ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-800"><?php echo htmlspecialchars($paciente->telefono ?? ''); ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-800"><?php echo htmlspecialchars($paciente->fechaNacimiento ?? ''); ?></td>
                                    <td class="px-6 py-4 text-center text-sm space-x-2">
                                        <a href="?view=editar_paciente&cedula=<?php echo urlencode($paciente->cedula ?? ''); ?>" 
                                           class="text-blue-600 hover:text-blue-800 font-semibold">Editar</a>
                                        <button onclick="eliminarPaciente('<?php echo htmlspecialchars($paciente->cedula ?? ''); ?>')" 
                                                class="text-red-600 hover:text-red-800 font-semibold">Eliminar</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="p-8 text-center text-gray-600">
                    <p class="text-lg">No hay pacientes registrados.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Botón Volver -->
        <div class="mt-6">
            <a href="?view=home" class="bg-gray-500 text-white px-6 py-2 rounded-lg font-semibold hover:bg-gray-600 transition inline-block">
                Volver al Inicio
            </a>
        </div>
    </div>

    <!-- Script para eliminar paciente -->
    <script>
        function eliminarPaciente(cedula) {
            if (confirm('¿Está seguro de que desea eliminar este paciente?')) {
                window.location.href = '?view=listar_pacientes&action=eliminar&cedula=' + encodeURIComponent(cedula);
            }
        }
    </script>

    <?php
    // Procesar eliminación si se solicitó
    if (isset($_GET['action']) && $_GET['action'] === 'eliminar' && isset($_GET['cedula'])) {
        $cedula = $_GET['cedula'];
        if ($controller->eliminar($cedula)) {
            echo '<script>window.location.href = "?view=listar_pacientes";</script>';
        }
    }
    ?>
</body>
</html>
