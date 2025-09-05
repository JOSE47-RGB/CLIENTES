<?php
include 'db.php';

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_cliente = $_POST['id_cliente'];
    $fecha_reserva = $_POST['fecha_reserva'];
    $hora_reserva = $_POST['hora_reserva'];
    $estado = $_POST['estado'];

    // Preparar la consulta SQL para insertar en la tabla reservas
    $query = "INSERT INTO reservas (id_cliente, fecha_reserva, hora_reserva, estado) VALUES (?, ?, ?, ?)";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("isss", $id_cliente, $fecha_reserva, $hora_reserva, $estado);
        $stmt->execute();
        $stmt->close();
    }

    // Redirigir a la página de lista de reservas
    header("Location: reservas.php");
    exit();
}

// Consultar clientes para el select
$clientes = $conn->query("SELECT id_cliente, nombre FROM clientes");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Reserva</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/fontawesome.min.css">
    <link rel="stylesheet" href="css/sweetalert2.min.css">
    <link rel="stylesheet" href="css/all.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="mb-4">Agregar Reserva</h1>
        <form id="addReservaForm" method="post" action="crear_reserva.php">
            <div class="mb-3">
                <label for="id_cliente" class="form-label">Cliente:</label>
                <select id="id_cliente" name="id_cliente" class="form-control" required>
                    <option value="">Seleccione un cliente</option>
                    <?php while ($row = $clientes->fetch_assoc()) { ?>
                        <option value="<?php echo $row['id_cliente']; ?>">
                            <?php echo htmlspecialchars($row['nombre']); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="fecha_reserva" class="form-label">Fecha de la Reserva:</label>
                <input type="date" id="fecha_reserva" name="fecha_reserva" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="hora_reserva" class="form-label">Hora de la Reserva:</label>
                <input type="time" id="hora_reserva" name="hora_reserva" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="estado" class="form-label">Estado:</label>
                <select id="estado" name="estado" class="form-control">
                    <option value="Pendiente">Pendiente</option>
                    <option value="Confirmada">Confirmada</option>
                    <option value="Cancelada">Cancelada</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Agregar</button>
            <a href="reservas.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>

    <script src="js/bootstrap.min.js"></script>
    <script src="js/all.min.js"></script>
    <script src="js/sweetalert2.all.min.js"></script>
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/fontawesome.min.js"></script>

    <!-- Confirmación con SweetAlert2 -->
    <script>
        document.getElementById('addReservaForm').addEventListener('submit', function(event) {
            event.preventDefault();
            Swal.fire({
                title: '¿Confirmar Reserva?',
                text: 'Se registrará la reserva seleccionada',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, registrar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('addReservaForm').submit();
                }
            });
        });
    </script>
</body>
</html>
