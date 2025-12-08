<?php 
require_once __DIR__ . '/../includes/config.php'; 
include __DIR__ . '/../includes/header.php'; 

if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION['admin_logged'])) { 
    header('Location: /perpus/pages/login.php'); 
    exit; 
}
?>

<style>
    .dashboard-container {
        width: 90%;
        margin: 20px auto;
        font-family: Arial, Helvetica, sans-serif;
    }

    .dashboard-title {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .dashboard-welcome {
        font-size: 18px;
        margin-bottom: 15px;
    }

    .dashboard-desc {
        background: #f7f9fc;
        padding: 15px 18px;
        border-left: 4px solid #4A90E2;
        border-radius: 6px;
        margin-bottom: 30px;
        line-height: 1.5;
        box-shadow: 0 1px 4px rgba(0,0,0,0.08);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
    }

    .stats-card {
        background: white;
        padding: 20px;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0px 3px 10px rgba(0,0,0,0.10);
        transition: transform .2s, box-shadow .2s;
        cursor: pointer;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0px 6px 14px rgba(0,0,0,0.15);
    }

    .stats-title {
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 10px;
        color: #333;
    }

    .stats-number {
        font-size: 40px;
        font-weight: bold;
        color: #4A90E2;
    }
</style>

<div class="dashboard-container">

    <h2 class="dashboard-title">Dashboard</h2>

    <p class="dashboard-welcome">
        Selamat datang, <strong><?= htmlspecialchars($_SESSION['admin_name']); ?></strong>
    </p>

    <div class="dashboard-desc">
        Selamat datang di <b>Sistem Peminjaman Buku Perpustakaan Online</b>. 
        Aplikasi ini dirancang untuk membantu pengelolaan data buku, 
        pendataan anggota perpustakaan, proses peminjaman serta pengembalian buku 
        secara cepat, efisien, dan akurat. Aplikasi ini dibuat untuk mempermudah proses peminjaman buku, pengelolaan data anggota, 
        pencatatan transaksi buku, serta monitoring data perpustakaan secara menyeluruh.  
        Sistem ini dikembangkan oleh <b>Rangga Anwar Ramadhan - 221011401214</b>.
    </div>

    <!-- Statistik Card -->
    <div class="stats-grid">

        <!-- Jumlah Buku -->
        <div class="stats-card">
            <div class="stats-title">Jumlah Buku</div>
            <?php $c = $conn->query('SELECT COUNT(*) as cnt FROM buku')->fetch_assoc(); ?>
            <div class="stats-number"><?= $c['cnt']; ?></div>
        </div>

        <!-- Transaksi Dipinjam -->
        <div class="stats-card">
            <div class="stats-title">Transaksi Dipinjam</div>
            <?php $c2 = $conn->query("SELECT COUNT(*) as cnt FROM peminjaman WHERE status='Dipinjam'")->fetch_assoc(); ?>
            <div class="stats-number"><?= $c2['cnt']; ?></div>
        </div>

    </div>

</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
