<?php
include 'db.php';

// Consultar todas las reservas junto con el nombre del cliente
$query = "SELECT r.id_reserva, c.nombre AS cliente, r.fecha_reserva, r.hora_reserva, r.estado
          FROM reservas r
          JOIN clientes c ON r.id_cliente = c.id_cliente
          ORDER BY r.fecha_reserva DESC, r.hora_reserva DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Reservas</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/fontawesome.min.css">
    <link rel="stylesheet" href="css/sweetalert2.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/dataTables.dataTables.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="mb-4">Lista de Reservas</h1>
        <a href="crear_reserva.php" class="btn btn-primary mb-3">Agregar Reserva</a>

        <table class="table table-striped table-bordered tableResponsiva">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['id_reserva']; ?></td>
                        <td><?php echo htmlspecialchars($row['cliente']); ?></td>
                        <td><?php echo $row['fecha_reserva']; ?></td>
                        <td><?php echo $row['hora_reserva']; ?></td>
                        <td><?php echo $row['estado']; ?></td>
                        <td>
                            <a href="editar_reserva.php?id=<?php echo $row['id_reserva']; ?>" 
                               class="btn btn-warning btn-sm">Editar</a>
                            <a href="eliminar_reserva.php?id=<?php echo $row['id_reserva']; ?>" 
                               class="btn btn-danger btn-sm eliminar-btn">Eliminar</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- JS -->
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/all.min.js"></script>
    <script src="js/sweetalert2.all.min.js"></script>
    <script src="js/dataTables.min.js"></script>

    <!-- Inicializar DataTables -->
    <script>
        $(document).ready(function() {
            $('.tableResponsiva').DataTable({
                "language": {
                    "decimal": ",",
                    "thousands": ".",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "lengthMenu": "Ver _MENU_ elementos",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ reservas",
                    "infoEmpty": "Mostrando 0 a 0 de 0 reservas",
                    "infoFiltered": "(filtrado de _MAX_ reservas)",
                    "loadingRecords": "Cargando...",
                    "zeroRecords": "No se encontraron resultados",
                    "emptyTable": "No hay reservas registradas",
                    "paginate": {
                        "first": "Primero",
                        "previous": "Anterior",
                        "next": "Siguiente",
                        "last": "Último"
                    }
                }
            });
        });
    </script>

    <!-- Confirmación eliminar con SweetAlert2 -->
    <script>
        document.querySelectorAll('.eliminar-btn').forEach(boton => {
            boton.addEventListener('click', function(event) {
                event.preventDefault();
                const url = this.getAttribute('href');

                Swal.fire({
                    title: '¿Eliminar reserva?',
                    text: "Esta acción no se puede deshacer",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            });
        });
    </script>
</body>
</html>
