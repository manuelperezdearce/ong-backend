-- ===========================================
-- CREACIÓN COMPLETA DE LA BASE DE DATOS
-- ===========================================

CREATE DATABASE ong_app CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE ong_app;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'user') DEFAULT 'user',
    avatar VARCHAR(255), -- opcional para guardar foto
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE EVENTO (
    id_evento INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    image VARCHAR(200),
    details TEXT,
    fecha DATE, -- ya incluida al crear la tabla
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE PROYECTO (
    id_proyecto INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    presupuesto DECIMAL(10, 2) DEFAULT 0, -- acumulado de donaciones
    goal DECIMAL(10, 2), -- meta de recaudación incluida directamente
    image VARCHAR(200),
    status ENUM('activo', 'finalizado') DEFAULT 'activo',
    fecha_inicio DATE,
    fecha_fin DATE
);

CREATE TABLE DONACION (
    id_donacion INT AUTO_INCREMENT PRIMARY KEY,
    monto DECIMAL(10, 2) NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- se crea automáticamente al insertar
    id_proyecto INT,
    id_usuario INT,
    FOREIGN KEY (id_proyecto) REFERENCES PROYECTO(id_proyecto) ON DELETE CASCADE,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE
);
