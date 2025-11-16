<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Paciente - GINPAC-SOAP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="bg-slate-50">
    <!-- Header -->
    <div class="bg-gradient-to-r from-green-600 to-cyan-600 text-white p-6 mb-8 rounded-b-lg">
        <div class="max-w-4xl mx-auto flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold">Registrar Nuevo Paciente</h1>
                <p class="text-green-100">Ingrese los datos del paciente</p>
            </div>
        </div>
    </div>

    <!-- Contenido -->
    <div class="max-w-4xl mx-auto px-4 pb-8">
        <?php
        $controller = new SoapClientController();
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cedula = $_POST['cedula'] ?? '';
            $nombres = $_POST['nombres'] ?? '';
            $apellidos = $_POST['apellidos'] ?? '';
            $telefono = $_POST['telefono'] ?? '';
            $fechaNacimiento = $_POST['fechaNacimiento'] ?? '';

            if ($cedula && $nombres && $apellidos && $telefono && $fechaNacimiento) {
                if ($controller->registrar($cedula, $nombres, $apellidos, $telefono, $fechaNacimiento)) {
                    $success = 'Paciente registrado exitosamente.';
                    $_POST = array();
                } else {
                    $error = 'Error al registrar: ' . ($controller->getError() ?: 'Verifique que la cédula no esté registrada.');
                }
                $controller->clearError();
            } else {
                $error = 'Por favor complete todos los campos.';
            }
        }
        ?>

        <!-- Mensaje de Éxito -->
        <?php if ($success): ?>
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6">
            <p><strong>Éxito:</strong> <?php echo $success; ?></p>
            <p class="text-sm mt-2"><a href="?view=crear_paciente" class="underline">Registrar otro</a> o <a href="?view=home" class="underline">volver al inicio</a></p>
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
                    <!-- Cédula -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cédula *</label>
                        <input type="text" name="cedula" value="<?php echo $_POST['cedula'] ?? ''; ?>" required 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                               placeholder="Ej: 1234567890">
                    </div>

                    <!-- Teléfono -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono *</label>
                        <input type="tel" name="telefono" value="<?php echo $_POST['telefono'] ?? ''; ?>" required 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                               placeholder="Ej: 3001234567">
                    </div>

                    <!-- Nombres -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nombres *</label>
                        <input type="text" name="nombres" value="<?php echo $_POST['nombres'] ?? ''; ?>" required 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                               placeholder="Ej: Juan">
                    </div>

                    <!-- Apellidos -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Apellidos *</label>
                        <input type="text" name="apellidos" value="<?php echo $_POST['apellidos'] ?? ''; ?>" required 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                               placeholder="Ej: Pérez">
                    </div>

                    <!-- Fecha de Nacimiento -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de Nacimiento *</label>
                        <input type="date" name="fechaNacimiento" value="<?php echo $_POST['fechaNacimiento'] ?? ''; ?>" required 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex gap-4 pt-4">
                    <button type="submit" class="btn-primary">Registrar Paciente</button>
                    <a href="?view=home" class="bg-gray-500 text-white px-6 py-2 rounded-lg font-semibold hover:bg-gray-600 transition inline-block">
                        Volver al Inicio
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
