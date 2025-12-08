<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('/perpus/pages/auth.php');
}

$email = sanitize($_POST['username']);
$pwd = md5($_POST['password']);

$stmt = $conn->prepare("SELECT id, nama, role FROM users WHERE email=? AND password=? LIMIT 1");
$stmt->bind_param("ss", $email, $pwd);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 1) {
    $row = $res->fetch_assoc();

    $_SESSION['admin_logged'] = true;
    $_SESSION['admin_id'] = $row['id'];
    $_SESSION['admin_name'] = $row['nama'];
    $_SESSION['role'] = $row['role'];

    redirect('/perpus/pages/dashboard.php');
} else {
    alert_and_redirect("Login gagal: cek email/password", "/perpus/pages/auth.php");
}
?>
