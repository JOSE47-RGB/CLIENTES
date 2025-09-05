<?php
include 'db.php';

// Consultar clientes y reservas
$clientes = $conn->query("SELECT * FROM clientes");
$reservas = $conn->query("
    SELECT r.id_reserva, c.nombre AS cliente, r.fecha_reserva, r.hora_reserva, r.estado
    FROM reservas r
    JOIN clientes c ON r.id_cliente = c.id_cliente
    ORDER BY r.fecha_reserva DESC, r.hora_reserva DESC
");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Principal</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="css/sweetalert2.min.css">
    <style>
        body {
            min-height: 100vh;
        }
        .sidebar {
            height: 100vh;
            position: fixed;
            width: 220px;
            background-color: #343a40;
            padding-top: 20px;
        }
        .sidebar a {
            display: block;
            color: #fff;
            padding: 12px;
            text-decoration: none;
            margin-bottom: 2px;
        }
        .sidebar a:hover {
            background-color: #495057;
            text-decoration: none;
        }
        .content {
            margin-left: 230px;
            padding: 20px;
        }
        .tableResponsiva {
            width: 100%;
        }
    </style>
</head>
<div class="mb-3">
    <a href="#" onclick="history.back();" class="btn btn-secondary">Regresar</a>
</div>

<body>
    <div class="sidebar">
        <h4 class="text-center text-white mb-4">Sistema</h4>
        <a href="#clientes">Clientes</a>
        <a href="#reservas">Reservas</a>
        <a href="crear.php">Agregar Cliente</a>
        <a href="crear_reserva.php">Agregar Reserva</a>
    </div>

    <div class="content">
        <h2 id="clientes">Lista de Clientes</h2>
        <table class="table table-striped table-bordered tableResponsiva mb-5">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $clientes->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id_cliente']; ?></td>
                    <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($row['correo']); ?></td>
                    <td><?php echo htmlspecialchars($row['telefono']); ?></td>
                    <td>
                        <a href="editar.php?id=<?php echo $row['id_cliente']; ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="borrar.php?id=<?php echo $row['id_cliente']; ?>" class="btn btn-danger btn-sm eliminar-btn">Borrar</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <h2 id="reservas">Lista de Reservas</h2>
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
                <?php while ($row = $reservas->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id_reserva']; ?></td>
                    <td><?php echo htmlspecialchars($row['cliente']); ?></td>
                    <td><?php echo $row['fecha_reserva']; ?></td>
                    <td><?php echo $row['hora_reserva']; ?></td>
                    <td><?php echo $row['estado']; ?></td>
                    <td>
                        <a href="editar_reserva.php?id=<?php echo $row['id_reserva']; ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="eliminar_reserva.php?id=<?php echo $row['id_reserva']; ?>" class="btn btn-danger btn-sm eliminar-btn">Eliminar</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/all.min.js"></script>
    <script src="js/dataTables.min.js"></script>
    <script src="js/sweetalert2.all.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.tableResponsiva').DataTable({
                "language": {
                    "decimal": ",",
                    "thousands": ".",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "lengthMenu": "Ver _MENU_ elementos",
                    "info": "Mostrando del _START_ al _END_ de _TOTAL_ elementos",
                    "infoEmpty": "Mostrando 0 a 0 de 0 elementos",
                    "infoFiltered": "(filtrado de _MAX_ elementos)",
                    "loadingRecords": "Cargando...",
                    "zeroRecords": "No se encontraron resultados",
                    "emptyTable": "No hay datos disponibles",
                    "paginate": {
                        "first": "Primero",
                        "previous": "Anterior",
                        "next": "Siguiente",
                        "last": "Último"
                    }
                }
            });

            // Confirmación eliminar
            document.querySelectorAll('.eliminar-btn').forEach(boton => {
                boton.addEventListener('click', function(event) {
                    event.preventDefault();
                    const url = this.getAttribute('href');
                    Swal.fire({
                        title: '¿Eliminar registro?',
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
        });
    </script>
</body>
</html>
