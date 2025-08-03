-- Database setup for SyntaxTrust backend
-- Run this script in your MySQL database

CREATE DATABASE IF NOT EXISTS company_profile_syntaxtrust;
USE company_profile_syntaxtrust;

-- Tabel users untuk autentikasi (sesuai struktur yang ada)
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    user_type ENUM('mahasiswa', 'bisnis', 'admin') DEFAULT 'mahasiswa',
    profile_image VARCHAR(255),
    bio TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    email_verified BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_user_type (user_type)
);

-- Insert sample users (password: admin123)
INSERT INTO users (username, email, password_hash, full_name) VALUES
('admin', 'admin@syntaxtrust.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin User'),
('john', 'john@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'John Doe'),
('jane', 'jane@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Jane Smith');

-- Settings table for site configuration
CREATE TABLE IF NOT EXISTS settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert default settings
INSERT INTO settings (setting_key, setting_value) VALUES
('site_name', 'SyntaxTrust'),
('site_description', 'Company Profile Management System'),
('site_logo', 'assets/img/logo.png'),
('site_favicon', 'assets/img/favicon.ico'),
('admin_email', 'admin@syntaxtrust.com');

-- Activity logs table
CREATE TABLE IF NOT EXISTS activity_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    action VARCHAR(100) NOT NULL,
    description TEXT,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- API tokens table for external integrations
CREATE TABLE IF NOT EXISTS api_tokens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    token VARCHAR(255) NOT NULL UNIQUE,
    name VARCHAR(100) NOT NULL,
    expires_at TIMESTAMP,
    is_active BOOLEAN DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Create indexes for better performance
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_users_active ON users(is_active);
CREATE INDEX idx_activity_logs_user ON activity_logs(user_id);
CREATE INDEX idx_activity_logs_created ON activity_logs(created_at);
CREATE INDEX idx_api_tokens_token ON api_tokens(token);
CREATE INDEX idx_api_tokens_user ON api_tokens(user_id);

-- Tabel mahasiswa untuk data mahasiswa (sesuai struktur yang ada)
CREATE TABLE IF NOT EXISTS mahasiswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    npm VARCHAR(10) UNIQUE NOT NULL,
    nama VARCHAR(100) NOT NULL,
    prodi VARCHAR(50) NOT NULL,
    angkatan INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id) REFERENCES users(id) ON DELETE CASCADE
);

-- Tabel bisnis untuk data bisnis (sesuai struktur yang ada)
CREATE TABLE IF NOT EXISTS bisnis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_bisnis VARCHAR(100) NOT NULL,
    jenis_bisnis VARCHAR(50) NOT NULL,
    alamat_bisnis TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id) REFERENCES users(id) ON DELETE CASCADE
);

-- Tabel laporan untuk data laporan (sesuai struktur yang ada)
CREATE TABLE IF NOT EXISTS laporan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul_laporan VARCHAR(100) NOT NULL,
    isi_laporan TEXT NOT NULL,
    tanggal_laporan DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id) REFERENCES users(id) ON DELETE CASCADE
);

-- Tabel pengalaman untuk data pengalaman (sesuai struktur yang ada)
CREATE TABLE IF NOT EXISTS pengalaman (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_pengalaman VARCHAR(100) NOT NULL,
    deskripsi_pengalaman TEXT NOT NULL,
    tanggal_pengalaman DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id) REFERENCES users(id) ON DELETE CASCADE
);

-- Tabel portofolio untuk data portofolio (sesuai struktur yang ada)
CREATE TABLE IF NOT EXISTS portofolio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_portofolio VARCHAR(100) NOT NULL,
    deskripsi_portofolio TEXT NOT NULL,
    tanggal_portofolio DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id) REFERENCES users(id) ON DELETE CASCADE
);

-- Tabel skill untuk data skill (sesuai struktur yang ada)
CREATE TABLE IF NOT EXISTS skill (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_skill VARCHAR(100) NOT NULL,
    deskripsi_skill TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id) REFERENCES users(id) ON DELETE CASCADE
);

-- Tabel testimonial untuk data testimonial (sesuai struktur yang ada)
CREATE TABLE IF NOT EXISTS testimonial (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_testimonial VARCHAR(100) NOT NULL,
    deskripsi_testimonial TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id) REFERENCES users(id) ON DELETE CASCADE
);

-- Create indexes for better performance
CREATE INDEX idx_mahasiswa_npm ON mahasiswa(npm);
CREATE INDEX idx_bisnis_nama_bisnis ON bisnis(nama_bisnis);
CREATE INDEX idx_laporan_judul_laporan ON laporan(judul_laporan);
CREATE INDEX idx_pengalaman_nama_pengalaman ON pengalaman(nama_pengalaman);
CREATE INDEX idx_portofolio_nama_portofolio ON portofolio(nama_portofolio);
CREATE INDEX idx_skill_nama_skill ON skill(nama_skill);
CREATE INDEX idx_testimonial_nama_testimonial ON testimonial(nama_testimonial);
