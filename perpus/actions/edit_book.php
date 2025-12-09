<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
session_start();

if (empty($_SESSION['admin_logged'])) {
    alert_and_redirect("Akses ditolak!", "/perpus/pages/login.php");
    exit;
}

$id       = intval($_POST['id']);
$judul    = sanitize($_POST['judul']);
$penulis  = sanitize($_POST['penulis']);
$penerbit = sanitize($_POST['penerbit']);
$tahun    = intval($_POST['tahun']);
$stok     = intval($_POST['stok']);

$cover_sql = "";

// Jika ada gambar baru diupload
if (!empty($_FILES['cover']['name'])) {

    $file = $_FILES['cover'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg','jpeg','png'];

    if (!in_array($ext, $allowed)) {
        alert_and_redirect("Format gambar tidak valid!", "/perpus/pages/buku.php");
    }

    $newname = "buku_" . time() . "_" . rand(100,999) . "." . $ext;
    $dir = __DIR__ . "/../uploads/buku/";

    move_uploaded_file($file['tmp_name'], $dir . $newname);

    $cover_sql = ", cover='$newname'";
}

// Update data buku
$sql = "UPDATE buku SET 
            judul='$judul',
            penulis='$penulis',
            penerbit='$penerbit',
            tahun_terbit='$tahun',
            stok='$stok'
            $cover_sql
        WHERE id=$id";

$conn->query($sql);

alert_and_redirect("Data buku berhasil diperbarui!", "/perpus/pages/buku.php");
