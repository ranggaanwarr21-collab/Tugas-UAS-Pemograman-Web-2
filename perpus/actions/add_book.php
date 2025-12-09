<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
session_start();

if (empty($_SESSION['admin_logged'])) {
    alert_and_redirect("Akses ditolak!", "/perpus/pages/login.php");
    exit;
}

// Ambil data input
$judul     = sanitize($_POST['judul'] ?? '');
$penulis   = sanitize($_POST['penulis'] ?? '');
$penerbit  = sanitize($_POST['penerbit'] ?? '');
$tahun     = intval($_POST['tahun'] ?? 0);
$stok      = intval($_POST['stok'] ?? 1);

// Validasi wajib isi
if ($judul === '') {
    alert_and_redirect("Judul wajib diisi!", "/perpus/pages/buku.php");
}

// Handle Upload Gambar
$cover_name = null;

if (!empty($_FILES['cover']['name'])) {

    $file     = $_FILES['cover'];
    $filename = $file['name'];
    $tmp      = $file['tmp_name'];
    $size     = $file['size'];

    // Folder tujuan
    $dir = __DIR__ . "/../uploads/buku/";

    // Buat folder jika belum ada
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }

    // Validasi ekstensi
    $allowed = ['jpg', 'jpeg', 'png'];
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed)) {
        alert_and_redirect("Format gambar harus JPG, JPEG, atau PNG!", "/perpus/pages/buku.php");
    }

    // Validasi ukuran (maks 2MB)
    if ($size > 2 * 1024 * 1024) {
        alert_and_redirect("Ukuran gambar terlalu besar! Maksimal 2MB.", "/perpus/pages/buku.php");
    }

    // Rename file agar unik
    $cover_name = "buku_" . time() . "_" . rand(100, 999) . "." . $ext;

    // Upload file
    if (!move_uploaded_file($tmp, $dir . $cover_name)) {
        alert_and_redirect("Gagal mengupload gambar!", "/perpus/pages/buku.php");
    }
}

// Simpan ke database
$stmt = $conn->prepare("INSERT INTO buku (judul, penulis, penerbit, tahun_terbit, stok, cover) 
                        VALUES (?, ?, ?, ?, ?, ?)");

$stmt->bind_param("sssiss", $judul, $penulis, $penerbit, $tahun, $stok, $cover_name);

if ($stmt->execute()) {
    alert_and_redirect("Buku berhasil ditambahkan!", "/perpus/pages/buku.php");
} else {
    alert_and_redirect("Gagal menyimpan buku ke database!", "/perpus/pages/buku.php");
}
?>
