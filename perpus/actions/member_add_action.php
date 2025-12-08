<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('/perpus/pages/member_add.php');
}

$nama = sanitize($_POST['nama']);
$nis = sanitize($_POST['nis']);
$telepon = sanitize($_POST['telepon']);
$alamat = sanitize($_POST['alamat']);
$gender = sanitize($_POST['gender']);

if ($nama === '' || $nis === '' || $telepon === '' || $alamat === '' || $gender === '') {
    alert_and_redirect('Semua data wajib diisi!', '/perpus/pages/member_add.php');
}

$stmt = $conn->prepare("
    INSERT INTO members (nama, nis, telepon, alamat, gender, created_at) 
    VALUES (?, ?, ?, ?, ?, NOW())
");
$stmt->bind_param('sssss', $nama, $nis, $telepon, $alamat, $gender);

if ($stmt->execute()) {
    alert_and_redirect('Member berhasil didaftarkan!', '/perpus/pages/member.php');
} else {
    alert_and_redirect('Gagal menyimpan data member!', '/perpus/pages/member_add.php');
}
