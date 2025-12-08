<?php require_once __DIR__ . '/../includes/config.php'; include __DIR__ . '/../includes/header.php'; 
if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION['admin_logged'])) { header('Location: /perpus/pages/login.php'); exit; }
$res = $conn->query("SELECT p.*, b.judul FROM peminjaman p JOIN buku b ON p.id_buku = b.id WHERE p.status='Dikembalikan' ORDER BY p.id DESC");
?>
<h2>Data Pengembalian</h2>
<a href="/perpus/pages/dashboard.php">&larr; Kembali</a>
<table>
  <tr><th>No</th><th>Peminjam</th><th>Judul Buku</th><th>Tgl Pinjam</th><th>Tgl Kembali</th></tr>
  <?php $no=1; while($r = $res->fetch_assoc()): ?>
  <tr>
    <td><?= $no++; ?></td>
    <td><?= htmlspecialchars($r['peminjam']); ?></td>
    <td><?= htmlspecialchars($r['judul']); ?></td>
    <td><?= htmlspecialchars($r['tanggal_pinjam']); ?></td>
    <td><?= htmlspecialchars($r['tanggal_kembali']); ?></td>
  </tr>
  <?php endwhile; ?>
</table>
<?php include __DIR__ . '/../includes/footer.php'; ?>