<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Perpustakaan Online - Sistem Peminjaman</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<header class="main-header">
  <div class="header-container">
      <h1 class="app-title">📚 Sistem Peminjaman Buku – Perpustakaan Online</h1>
      
      <?php if (!empty($_SESSION['admin_logged'])): ?>
      <nav class="navbar">
          <a href="/perpus/pages/dashboard.php" class="nav-link">Dashboard</a>
          <a href="/perpus/pages/buku.php" class="nav-link">Buku</a>
          <a href="/perpus/pages/peminjaman.php" class="nav-link">Peminjaman</a>
          <a href="/perpus/pages/pengembalian.php" class="nav-link">Pengembalian</a>
          <a href="/perpus/pages/member_add.php" class="nav-link">Anggota</a>
          <a href="/perpus/actions/logout_action.php" class="nav-link logout">Logout</a>
      </nav>
      <?php endif; ?>
  </div>
</header>

<main class="content-wrapper">
