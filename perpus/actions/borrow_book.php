<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
session_start();
if (empty($_SESSION['admin_logged'])) redirect('/perpus/pages/login.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_buku = intval($_POST['id_buku'] ?? 0);
    $peminjam = sanitize($_POST['peminjam'] ?? '');
    if ($id_buku <= 0 || $peminjam === '') {
        alert_and_redirect('Data tidak lengkap', '/perpus/pages/peminjaman.php');
    }
    // check stok
    $stmt = $conn->prepare('SELECT stok FROM buku WHERE id = ? LIMIT 1');
    $stmt->bind_param('i', $id_buku);
    $stmt->execute();
    $res = $stmt->get_result();
    if (!$res || $res->num_rows === 0) {
        alert_and_redirect('Buku tidak ditemukan', '/perpus/pages/peminjaman.php');
    }
    $row = $res->fetch_assoc();
    if ($row['stok'] <= 0) {
        alert_and_redirect('Stok tidak cukup', '/perpus/pages/peminjaman.php');
    }
    // insert peminjaman
    $tgl_pinjam = date('Y-m-d');
    $tgl_kembali = date('Y-m-d', strtotime('+7 days'));
    $stmt = $conn->prepare('INSERT INTO peminjaman (id_buku, peminjam, tanggal_pinjam, tanggal_kembali, status) VALUES (?, ?, ?, ?, ?)');
    $status = 'Dipinjam';
    $stmt->bind_param('issss', $id_buku, $peminjam, $tgl_pinjam, $tgl_kembali, $status);
    if ($stmt->execute()) {
        // kurangi stok
        $upd = $conn->prepare('UPDATE buku SET stok = stok - 1 WHERE id = ?');
        $upd->bind_param('i', $id_buku);
        $upd->execute();
        alert_and_redirect('Transaksi pinjam berhasil', '/perpus/pages/peminjaman.php');
    } else {
        alert_and_redirect('Gagal menyimpan transaksi', '/perpus/pages/peminjaman.php');
    }
} else {
    redirect('/perpus/pages/peminjaman.php');
}
?>