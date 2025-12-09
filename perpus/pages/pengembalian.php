<?php 
require_once __DIR__ . '/../includes/config.php'; 
include __DIR__ . '/../includes/header.php';

if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION['admin_logged'])) { 
    header('Location: /perpus/pages/login.php'); 
    exit; 
}

$res = $conn->query("
    SELECT p.*, b.judul 
    FROM peminjaman p 
    JOIN buku b ON p.id_buku = b.id 
    WHERE p.status='Dikembalikan' 
    ORDER BY p.id DESC
");
?>

<style>
    .page-title {
        font-size: 26px;
        font-weight: 600;
        margin-bottom: 15px;
        color: #333;
        text-align: center;
    }

    .back-link {
        display: inline-block;
        margin-bottom: 20px;
        color: #007bff;
        text-decoration: none;
        font-weight: 500;
    }
    .back-link:hover { text-decoration: underline; }

    .card-wrapper {
        background: #ffffff;
        padding: 25px;
        border-radius: 12px;
        max-width: 980px;
        margin: 0 auto;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
        border-radius: 10px;
        overflow: hidden;
    }

    table th {
        background: #4f6df5;
        color: white;
        padding: 12px;
        text-align: center;
        font-weight: 600;
    }

    table td {
        padding: 10px;
        text-align: center;
        background: #fafafa;
        border-bottom: 1px solid #e5e5e5;
    }

    table tr:nth-child(even) td {
        background: #f0f4ff;
    }
</style>

<div class="card-wrapper">
    <h2 class="page-title">📚 Data Pengembalian Buku</h2>

    <a class="back-link" href="/perpus/pages/dashboard.php">&larr; Kembali ke Dashboard</a>

    <table>
        <tr>
            <th>No</th>
            <th>Peminjam</th>
            <th>Judul Buku</th>
            <th>Tgl Pinjam</th>
            <th>Tgl Kembali</th>
        </tr>

        <?php $no = 1; while ($r = $res->fetch_assoc()): ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($r['peminjam']); ?></td>
            <td><?= htmlspecialchars($r['judul']); ?></td>
            <td><?= htmlspecialchars($r['tanggal_pinjam']); ?></td>
            <td><?= htmlspecialchars($r['tanggal_kembali']); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
