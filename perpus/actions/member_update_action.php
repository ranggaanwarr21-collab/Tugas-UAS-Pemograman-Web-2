<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('/perpus/pages/member.php');
}

$id = intval($_POST['id']);
$nama = sanitize($_POST['nama']);
$nis = sanitize($_POST['nis']);
$telepon = sanitize($_POST['telepon']);
$alamat = sanitize($_POST['alamat']);
$gender = sanitize($_POST['gender']);

$stmt = $conn->prepare("
    UPDATE members 
    SET nama=?, nis=?, telepon=?, alamat=?, gender=?
    WHERE id=?
");
$stmt->bind_param("sssssi", $nama, $nis, $telepon, $alamat, $gender, $id);

if ($stmt->execute()) {
    alert_and_redirect("Data member berhasil diperbarui!", "/perpus/pages/member.php");
} else {
    alert_and_redirect("Gagal mengupdate data!", "/perpus/pages/member_edit.php?id=$id");
}
