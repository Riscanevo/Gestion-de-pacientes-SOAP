<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Paciente - GINPAC-SOAP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="bg-slate-50">
    <!-- Header -->
    <div class="bg-gradient-to-r from-green-600 to-cyan-600 text-white p-6 mb-8 rounded-b-lg">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold">Editar Paciente</h1>
            <p class="text-green-100">Modifique los datos del paciente</p>
        </div>
    </div>

    <!-- Contenido -->
    <div class="max-w-4xl mx-auto px-4 pb-8">
        <?php
        $controller = new SoapClientController();
        $cedula = $_GET['cedula'] ?? '';
        $paciente = $cedula ? $controller->buscar($cedula) : null;
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cedula = $_POST['cedula'] ?? '';
            $nombres = $_POST['nombres'] ?? '';
            $apellidos = $_POST['apellidos'] ?? '';
            $telefono = $_POST['telefono'] ?? '';
            $fechaNacimiento = $_POST['fechaNacimiento'] ?? '';

            if ($cedula && $nombres && $apellidos && $telefono && $fechaNacimiento) {
                if ($controller->actualizar($cedula, $nombres, $apellidos, $telefono, $fechaNacimiento)) {
                    $success = 'Paciente actualizado exitosamente.';
                    $paciente = $controller->buscar($cedula);
                } else {
                    $error = 'Error al actualizar: ' . ($controller->getError() ?: 'Por favor intente de nuevo.');
                }
                $controller->clearError();
            } else {
                $error = 'Por favor complete todos los campos.';
            }
        }

        if (!$paciente):
        ?>
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6">
                <p><strong>Error:</strong> No se encontró el paciente solicitado.</p>
            </div>
            <a href="?view=home" class="bg-gray-500 text-white px-6 py-2 rounded-lg font-semibold hover:bg-gray-600 transition inline-block">
                Volver al Inicio
            </a>
        <?php else: ?>

        <!-- Mensaje de Éxito -->
        <?php if ($success): ?>
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6">
            <p><strong>Éxito:</strong> <?php echo $success; ?></p>
        </div>
        <?php endif; ?>

        <!-- Mensaje de Error -->
        <?php if ($error): ?>
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6">
            <p><strong>Error:</strong> <?php echo $error; ?></p>
        </div>
        <?php endif; ?>

        <!-- Formulario -->
        <div class="bg-white rounded-lg shadow p-8 mb-6">
            <form method="POST" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Cédula (solo lectura) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cédula</label>
                        <input type="text" value="<?php echo htmlspecialchars($paciente->cedula ?? ''); ?>" disabled 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600">
                        <input type="hidden" name="cedula" value="<?php echo htmlspecialchars($paciente->cedula ?? ''); ?>">
                    </div>

                    <!-- Teléfono -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono *</label>
                        <input type="tel" name="telefono" value="<?php echo htmlspecialchars($paciente->telefono ?? ''); ?>" required 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>

                    <!-- Nombres -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nombres *</label>
                        <input type="text" name="nombres" value="<?php echo htmlspecialchars($paciente->nombres ?? ''); ?>" required 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>

                    <!-- Apellidos -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Apellidos *</label>
                        <input type="text" name="apellidos" value="<?php echo htmlspecialchars($paciente->apellidos ?? ''); ?>" required 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>

                    <!-- Fecha de Nacimiento -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de Nacimiento *</label>
                        <input type="date" name="fechaNacimiento" value="<?php echo htmlspecialchars($paciente->fechaNacimiento ?? ''); ?>" required 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex gap-4 pt-4">
                    <button type="submit" class="btn-primary">Guardar Cambios</button>
                    <a href="?view=listar_pacientes" class="bg-gray-500 text-white px-6 py-2 rounded-lg font-semibold hover:bg-gray-600 transition inline-block">
                        Volver al Listado
                    </a>
                </div>
            </form>
        </div>

        <?php endif; ?>
    </div>
</body>
</html>
