<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
session_start();
if (empty($_SESSION['admin_logged'])) redirect('/perpus/pages/login.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    // ambil data peminjaman
    $stmt = $conn->prepare('SELECT id_buku, status FROM peminjaman WHERE id = ? LIMIT 1');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $res = $stmt->get_result();
    if (!$res || $res->num_rows === 0) {
        alert_and_redirect('Data peminjaman tidak ditemukan', '/perpus/pages/peminjaman.php');
    }
    $row = $res->fetch_assoc();
    if ($row['status'] === 'Dikembalikan') {
        alert_and_redirect('Sudah dikembalikan sebelumnya', '/perpus/pages/peminjaman.php');
    }
    // update peminjaman
    $tgl_kembali = date('Y-m-d');
    $st = 'Dikembalikan';
    $u = $conn->prepare('UPDATE peminjaman SET status = ?, tanggal_kembali = ? WHERE id = ?');
    $u->bind_param('ssi', $st, $tgl_kembali, $id);
    if ($u->execute()) {
        // tambah stok buku
        $upd = $conn->prepare('UPDATE buku SET stok = stok + 1 WHERE id = ?');
        $upd->bind_param('i', $row['id_buku']);
        $upd->execute();
        alert_and_redirect('Buku berhasil dikembalikan', '/perpus/pages/peminjaman.php');
    } else {
        alert_and_redirect('Gagal update pengembalian', '/perpus/pages/peminjaman.php');
    }
} else {
    redirect('/perpus/pages/peminjaman.php');
}
?>