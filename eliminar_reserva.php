<?php
include 'db.php';

// Verificar que se reciba el ID
if (!isset($_GET['id'])) {
    header("Location: reservas.php");
    exit();
}

$id_reserva = $_GET['id'];

// Eliminar la reserva
$query = "DELETE FROM reservas WHERE id_reserva = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_reserva);

if ($stmt->execute()) {
    $stmt->close();
    header("Location: reservas.php?mensaje=eliminada");
    exit();
} else {
    echo "Error al eliminar la reserva.";
}
?>
