-- database.sql
CREATE DATABASE IF NOT EXISTS sims_db;
USE sims_db;

-- 1. Table ya Watumiaji ikiwa na safu ya ROLE (Admin, Teacher, Staff)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('Admin', 'Teacher', 'Staff') DEFAULT 'Teacher',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Table ya Wanafunzi (Tanzania Primary & Secondary Case)
CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reg_number VARCHAR(50) NOT NULL UNIQUE,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    gender ENUM('Male', 'Female') NOT NULL,
    school_level ENUM('Primary', 'Secondary') NOT NULL,
    class_level VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Kuingiza mtumiaji wa mfano mwenye mamlaka ya 'Admin' (Password yake bado ni: admin123)
INSERT INTO users (name, email, password, role) VALUES 
('Muksini Bushiri', 'admin@sims.ac.tz', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin')
ON DUPLICATE KEY UPDATE id=id;