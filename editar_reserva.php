<?php
include 'db.php';

// Verificar si se pasó un ID válido
if (!isset($_GET['id'])) {
    header("Location: reservas.php");
    exit();
}

$id_reserva = $_GET['id'];

// Obtener datos de la reserva
$query = "SELECT * FROM reservas WHERE id_reserva = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_reserva);
$stmt->execute();
$result = $stmt->get_result();
$reserva = $result->fetch_assoc();

if (!$reserva) {
    echo "Reserva no encontrada.";
    exit();
}
$stmt->close();

// Procesar formulario al enviar
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_cliente = $_POST['id_cliente'];
    $fecha_reserva = $_POST['fecha_reserva'];
    $hora_reserva = $_POST['hora_reserva'];
    $estado = $_POST['estado'];

    $updateQuery = "UPDATE reservas SET id_cliente=?, fecha_reserva=?, hora_reserva=?, estado=? WHERE id_reserva=?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("isssi", $id_cliente, $fecha_reserva, $hora_reserva, $estado, $id_reserva);
    $stmt->execute();
    $stmt->close();

    header("Location: reservas.php");
    exit();
}

// Obtener clientes para el select
$clientes = $conn->query("SELECT id_cliente, nombre FROM clientes");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Reserva</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/fontawesome.min.css">
    <link rel="stylesheet" href="css/sweetalert2.min.css">
    <link rel="stylesheet" href="css/all.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="mb-4">Editar Reserva</h1>
        <form id="editReservaForm" method="post" action="">
            <div class="mb-3">
                <label for="id_cliente" class="form-label">Cliente:</label>
                <select id="id_cliente" name="id_cliente" class="form-control" required>
                    <?php while ($row = $clientes->fetch_assoc()) { ?>
                        <option value="<?php echo $row['id_cliente']; ?>"
                            <?php if ($row['id_cliente'] == $reserva['id_cliente']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($row['nombre']); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="fecha_reserva" class="form-label">Fecha de la Reserva:</label>
                <input type="date" id="fecha_reserva" name="fecha_reserva" class="form-control" 
                       value="<?php echo $reserva['fecha_reserva']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="hora_reserva" class="form-label">Hora de la Reserva:</label>
                <input type="time" id="hora_reserva" name="hora_reserva" class="form-control" 
                       value="<?php echo $reserva['hora_reserva']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="estado" class="form-label">Estado:</label>
                <select id="estado" name="estado" class="form-control">
                    <option value="Pendiente" <?php if ($reserva['estado'] == 'Pendiente') echo 'selected'; ?>>Pendiente</option>
                    <option value="Confirmada" <?php if ($reserva['estado'] == 'Confirmada') echo 'selected'; ?>>Confirmada</option>
                    <option value="Cancelada" <?php if ($reserva['estado'] == 'Cancelada') echo 'selected'; ?>>Cancelada</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Guardar Cambios</button>
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
        document.getElementById('editReservaForm').addEventListener('submit', function(event) {
            event.preventDefault();
            Swal.fire({
                title: '¿Guardar cambios?',
                text: 'Se actualizará la información de la reserva',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, guardar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('editReservaForm').submit();
                }
            });
        });
    </script>
</body>
</html>
