CREATE DATABASE IF NOT EXISTS farmacia_vav CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE farmacia_vav;

CREATE TABLE IF NOT EXISTS produtos (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    nome       VARCHAR(150) NOT NULL,
    fabricante VARCHAR(100) NOT NULL,
    preco      DECIMAL(10,2) NOT NULL,
    estoque    INT NOT NULL DEFAULT 0
);

INSERT INTO produtos (nome, fabricante, preco, estoque) VALUES
('Paracetamol 750mg', 'EMS',        8.90, 150),
('Dipirona 500mg',    'Medley',     6.50, 200),
('Vitamina C 1g',     'Cimed',     22.00,  80),
('Omeprazol 20mg',    'Eurofarma', 18.75,  60),
('Amoxicilina 500mg', 'Teuto',     35.00,  45);
