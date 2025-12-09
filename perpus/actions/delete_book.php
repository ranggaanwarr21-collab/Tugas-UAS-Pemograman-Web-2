<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
session_start();

$id = intval($_GET['id']);

// Hapus cover
$q = $conn->query("SELECT cover FROM buku WHERE id=$id");
$r = $q->fetch_assoc();

if (!empty($r['cover'])) {
    $file = __DIR__ . "/../uploads/buku/" . $r['cover'];
    if (file_exists($file)) unlink($file);
}

// Hapus dari database
$conn->query("DELETE FROM buku WHERE id=$id");

alert_and_redirect("Buku berhasil dihapus!", "/perpus/pages/buku.php");
