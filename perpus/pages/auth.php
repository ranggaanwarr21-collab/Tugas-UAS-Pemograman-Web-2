<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

if (!empty($_SESSION['admin_logged'])) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login / Register - Perpus</title>
    <link rel="stylesheet" href="../assets/css/auth.css">
    <style>
        body { font-family: Arial; background: #f4f4f4; display:flex; justify-content:center; padding:40px; }
        .container { width: 420px; background:#fff; padding:25px; border-radius:10px; box-shadow:0 0 10px rgba(0,0,0,.1); }
        h2 { text-align:center; }
        input, button { width:100%; padding:10px; margin:7px 0; border-radius:6px; border:1px solid #ccc; }
        button { background:#007bff; color:white; cursor:pointer; border:none; }
        button:hover { background:#0056b3; }
        .switch { text-align:center; margin-top:10px; }
        .switch a { cursor:pointer; color:#007bff; }
        .hidden { display:none; }
    </style>
</head>
<body>

<div class="container">

    <!-- LOGIN FORM -->
    <div id="loginForm">
        <h2>Login</h2>
        <form method="POST" action="/perpus/actions/login_action.php">
            <label>Email:</label>
            <input type="text" name="username" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <button type="submit">Masuk</button>
        </form>
        <div class="switch">
            Belum punya akun? <a onclick="showRegister()">Daftar disini</a>
        </div>
    </div>

    <!-- REGISTER FORM -->
    <div id="registerForm" class="hidden">
        <h2>Daftar Member</h2>
        <form method="POST" action="/perpus/actions/register_action.php">
            <label>Nama Lengkap:</label>
            <input type="text" name="nama" required>

            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <button type="submit">Daftar</button>
        </form>
        <div class="switch">
            Sudah punya akun? <a onclick="showLogin()">Login disini</a>
        </div>
    </div>

</div>

<script>
function showRegister(){
    document.getElementById('loginForm').classList.add('hidden');
    document.getElementById('registerForm').classList.remove('hidden');
}
function showLogin(){
    document.getElementById('registerForm').classList.add('hidden');
    document.getElementById('loginForm').classList.remove('hidden');
}
</script>

</body>
</html>
