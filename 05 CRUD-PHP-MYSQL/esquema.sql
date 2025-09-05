-- Crear la base de datos
CREATE DATABASE sistema_reservas;
USE sistema_reservas;

-- Tabla de clientes
CREATE TABLE clientes (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE,
    telefono VARCHAR(15) NOT NULL
);

-- Tabla de reservas
CREATE TABLE reservas (
    id_reserva INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT NOT NULL,
    fecha_reserva DATE NOT NULL,
    hora_reserva TIME NOT NULL,
    estado ENUM('Pendiente','Confirmada','Cancelada') DEFAULT 'Pendiente',
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente)
);

-- Datos de ejemplo (opcionales)
INSERT INTO clientes (nombre, correo, telefono) VALUES
('Juan Pérez', 'juan@example.com', '555-1234'),
('María López', 'maria@example.com', '555-5678');

INSERT INTO reservas (id_cliente, fecha_reserva, hora_reserva, estado) VALUES
(1, '2025-08-20', '10:00:00', 'Pendiente'),
(2, '2025-08-21', '14:30:00', 'Confirmada');
