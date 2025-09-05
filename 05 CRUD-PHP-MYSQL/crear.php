<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];

    // Preparar la consulta SQL para la tabla clientes
    $query = "INSERT INTO clientes (nombre, correo, telefono) VALUES (?, ?, ?)";

    // Preparar la declaración
    if ($stmt = $conn->prepare($query)) {
        // Vincular los parámetros
        $stmt->bind_param("sss", $nombre, $correo, $telefono);

        // Ejecutar la declaración
        $stmt->execute();

        // Cerrar la declaración
        $stmt->close();
    }

    // Redirigir a la página de inicio
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Cliente</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/fontawesome.min.css">
    <link rel="stylesheet" href="css/sweetalert2.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="icon" href="Resources/icono.ico" type="image/x-icon">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="mb-4">Agregar Cliente</h1>
        <form id="addClientForm" method="post" action="crear.php">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="correo" class="form-label">Correo:</label>
                <input type="email" id="correo" name="correo" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary" id="submitBtn">Agregar</button>
            <a href="index.php" class="btn btn-secondary">Regresar</a>
        </form>
    </div>

    <script src="js/bootstrap.min.js"></script>
    <script src="js/all.min.js"></script>
    <script src="js/sweetalert2.all.min.js"></script>
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/fontawesome.min.js"></script>

    <!-- Script para SweetAlert2 -->
    <script>
        document.getElementById('addClientForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevenir el envío del formulario por defecto

            Swal.fire({
                title: '¿Estás seguro?',
                text: '¿Quieres agregar este cliente?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, agregar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Si el usuario confirma, envía el formulario
                    document.getElementById('addClientForm').submit();
                }
            });
        });
    </script>
</body>
</html>
