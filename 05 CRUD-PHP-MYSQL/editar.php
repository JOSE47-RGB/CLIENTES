<?php
include 'db.php';

$id = $_GET['id'];

// Preparar la consulta para seleccionar el cliente
$query = "SELECT * FROM clientes WHERE id_cliente = ?";
if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $cliente = $result->fetch_assoc();
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];

    // Preparar la consulta para actualizar el cliente
    $query = "UPDATE clientes SET nombre = ?, correo = ?, telefono = ? WHERE id_cliente = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("sssi", $nombre, $correo, $telefono, $id);
        $stmt->execute();
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
    <title>Editar Cliente</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/fontawesome.min.css">
    <link rel="stylesheet" href="css/sweetalert2.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="icon" href="Resources/icono.ico" type="image/x-icon">
</head>
<body class="bg-light">
    <div class="container mt-4">
        <h1>Editar Cliente</h1>
        <form method="post" action="" id="editForm">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="form-control" 
                       value="<?php echo htmlspecialchars($cliente['nombre']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="correo" class="form-label">Correo:</label>
                <input type="email" id="correo" name="correo" class="form-control" 
                       value="<?php echo htmlspecialchars($cliente['correo']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" class="form-control" 
                       value="<?php echo htmlspecialchars($cliente['telefono']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>

    <script src="js/bootstrap.min.js"></script>
    <script src="js/all.min.js"></script>
    <script src="js/sweetalert2.all.min.js"></script>
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/fontawesome.min.js"></script>

    <!-- Script para SweetAlert2 -->
    <script>
        document.getElementById('editForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevenir el envío del formulario por defecto

            Swal.fire({
                title: '¿Estás seguro?',
                text: '¿Quieres guardar los cambios?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, guardar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Si el usuario confirma, envía el formulario
                    document.getElementById('editForm').submit();
                }
            });
        });
    </script>
</body>
</html>
