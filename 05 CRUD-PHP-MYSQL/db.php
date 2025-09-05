<?php
$servidor = "localhost";  // Dirección del servidor
$usuario = "root";         // Nombre de usuario de la base de datos
$contrasena = "";          // Contraseña del usuario (por defecto vacía)
$base_datos = "sistema_reservas";  // Nombre de la base de datos

// Crear la conexión
$conn = new mysqli($servidor, $usuario, $contrasena, $base_datos);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>


