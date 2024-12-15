-- Create database
CREATE DATABASE kebabbabakinan;

-- Use the database
USE kebabbabakinan;

-- Create table for users
CREATE TABLE users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(15),
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create table for makanan
CREATE TABLE makanan (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama_makanan VARCHAR(100) NOT NULL,
    harga INT NOT NULL
);

-- Create table for pesanan
CREATE TABLE pesanan (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    users_id INT(6) UNSIGNED NOT NULL,
    makanan_id INT(6) UNSIGNED NOT NULL,
    total_harga INT NOT NULL,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (users_id) REFERENCES users(id),
    FOREIGN KEY (makanan_id) REFERENCES makanan(id)
);

-- Insert data into makanan table
INSERT INTO makanan (id, nama_makanan, harga) VALUES
(1, 'Kebab Sapi', 15000),
(2, 'Kebab Ayam', 12000);
