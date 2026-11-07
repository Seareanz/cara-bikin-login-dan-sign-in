-- =====================================================
--  db.sql — Database untuk tutorial Website Dinamis
--  Cara pakai:
--  1. Buka http://localhost/phpmyadmin
--  2. Klik tab "SQL" (atau tombol New untuk bikin DB)
--  3. Salin semua kode ini, tempel, klik "Go" / "Simpan"
-- =====================================================

-- 1. Buat database-nya
CREATE DATABASE IF NOT EXISTS db_login
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

-- 2. Pakai database itu
USE db_login;

-- 3. Buat tabel untuk menyimpan akun pengguna
CREATE TABLE IF NOT EXISTS users (
  id         INT AUTO_INCREMENT PRIMARY KEY,
  username   VARCHAR(50)  NOT NULL UNIQUE,
  email      VARCHAR(100) NOT NULL UNIQUE,
  password   VARCHAR(255) NOT NULL,
  created_at TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 4. Cek: tabel apa saja yang ada di database ini
SHOW TABLES;
