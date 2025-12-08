<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('/perpus/pages/auth.php');
}

$nama = sanitize($_POST['nama']);
$email = sanitize($_POST['email']);
$pass = md5($_POST['password']); // SAMA seperti login_action

// Cek email sudah digunakan?
$check = $conn->prepare("SELECT id FROM users WHERE email=? LIMIT 1");
$check->bind_param("s", $email);
$check->execute();
$res = $check->get_result();

if ($res->num_rows > 0) {
    alert_and_redirect("Email sudah terdaftar!", "/perpus/pages/auth.php");
}

// Insert user baru (role default = user)
$stmt = $conn->prepare("INSERT INTO users (nama, email, password, role) VALUES (?, ?, ?, 'user')");
$stmt->bind_param("sss", $nama, $email, $pass);

if ($stmt->execute()) {
    alert_and_redirect("Registrasi berhasil! Silakan login.", "/perpus/pages/auth.php");
} else {
    alert_and_redirect("Terjadi kesalahan!", "/perpus/pages/auth.php");
}
