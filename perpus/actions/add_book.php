<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/header.php';

if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION['admin_logged'])) {
    redirect('/perpus/pages/login.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = sanitize($_POST['judul'] ?? '');
    $penulis = sanitize($_POST['penulis'] ?? '');
    $penerbit = sanitize($_POST['penerbit'] ?? '');
    $tahun = intval($_POST['tahun'] ?? 0);
    $stok = intval($_POST['stok'] ?? 0);

    if ($judul === '') {
        alert_and_redirect('Judul wajib diisi', '/perpus/pages/buku.php');
    }

    $stmt = $conn->prepare('INSERT INTO buku (judul, penulis, penerbit, tahun_terbit, stok) VALUES (?, ?, ?, ?, ?)');
    $stmt->bind_param('sssii', $judul, $penulis, $penerbit, $tahun, $stok);
    if ($stmt->execute()) {
        alert_and_redirect('Buku berhasil ditambahkan', '/perpus/pages/buku.php');
    } else {
        alert_and_redirect('Gagal menambahkan buku', '/perpus/pages/buku.php');
    }
} else {
    redirect('/perpus/pages/buku.php');
}
?>