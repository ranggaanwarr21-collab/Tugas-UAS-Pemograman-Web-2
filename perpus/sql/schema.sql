-- Database schema (admin-only, bahasa indonesia)
CREATE DATABASE IF NOT EXISTS perpus;
USE perpus;

DROP TABLE IF EXISTS peminjaman;
DROP TABLE IF EXISTS buku;
DROP TABLE IF EXISTS admin;

CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

INSERT INTO admin (nama, email, password) VALUES
('Administrator', 'admin@perpus.com', MD5('admin123'));

CREATE TABLE buku (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    penulis VARCHAR(255),
    penerbit VARCHAR(255),
    tahun_terbit INT,
    stok INT DEFAULT 0
);

INSERT INTO buku (judul, penulis, penerbit, tahun_terbit, stok) VALUES
('Laskar Pelangi', 'Andrea Hirata', 'Bentang Pustaka', 2005, 10),
('Bumi Manusia', 'Pramoedya Ananta Toer', 'Hasta Mitra', 1980, 5),
('Negeri 5 Menara', 'Ahmad Fuadi', 'Gramedia', 2009, 7);

CREATE TABLE peminjaman (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_buku INT NOT NULL,
    peminjam VARCHAR(255) NOT NULL,
    tanggal_pinjam DATE DEFAULT (CURRENT_DATE),
    tanggal_kembali DATE DEFAULT NULL,
    status ENUM('Dipinjam','Dikembalikan') DEFAULT 'Dipinjam',
    FOREIGN KEY (id_buku) REFERENCES buku(id) ON DELETE CASCADE
);

-- sample peminjaman demo
INSERT INTO peminjaman (id_buku, peminjam, tanggal_pinjam, tanggal_kembali, status) VALUES
(1, 'Siswa A', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 7 DAY), 'Dipinjam');
