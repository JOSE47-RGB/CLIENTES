<?php
include 'db.php';

// Verificar si se ha confirmado la eliminación
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirmar'])) {
    $id = $_POST['id'];

    // Preparar la consulta para eliminar el cliente
    $query = "DELETE FROM clientes WHERE id_cliente = ?";
    if ($stmt = $conn->prepare($query)) {
        // Vincular el parámetro (el ID del cliente)
        $stmt->bind_param("i", $id);

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
    <title>Confirmar Eliminación</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/fontawesome.min.css">
    <link rel="stylesheet" href="css/sweetalert2.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="icon" href="Resources/icono.ico" type="image/x-icon">
</head>
<body class="bg-light">
    <div class="container mt-4">
        <h1>Confirmar Eliminación</h1>
        <p>¿Estás seguro de que deseas eliminar este cliente?</p>
        <button id="confirmar" class="btn btn-danger">Eliminar</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </div>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/all.min.js"></script>
    <script src="js/sweetalert2.all.min.js"></script>
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/fontawesome.min.js"></script>
    
    <!-- Script para SweetAlert2 -->
    <script>
        document.getElementById('confirmar').addEventListener('click', function() {
            const clienteId = new URLSearchParams(window.location.search).get('id');

            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Enviar la solicitud POST para confirmar la eliminación
                    fetch('borrar.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: new URLSearchParams({
                            'confirmar': 'true',
                            'id': clienteId
                        })
                    }).then(response => {
                        if (response.redirected) {
                            window.location.href = response.url;
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
