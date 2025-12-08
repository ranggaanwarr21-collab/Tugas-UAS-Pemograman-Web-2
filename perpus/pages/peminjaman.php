<?php require_once __DIR__ . '/../includes/config.php'; include __DIR__ . '/../includes/header.php'; 
if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION['admin_logged'])) { header('Location: /perpus/pages/login.php'); exit; }
$res = $conn->query("SELECT p.*, b.judul FROM peminjaman p JOIN buku b ON p.id_buku = b.id ORDER BY p.id DESC");
$books = $conn->query('SELECT id, judul, stok FROM buku WHERE stok > 0 ORDER BY judul ASC');
?>
<h2>Data Peminjaman</h2>
<a href="/perpus/pages/dashboard.php">&larr; Kembali</a>
<div style="margin:15px 0;">
  <button onclick="document.getElementById('formPinjam').style.display='block'">+ Tambah Peminjaman</button>
</div>
<div id="formPinjam" style="display:none; background:#fff; padding:15px; width:90%; margin:0 auto 20px; border-radius:6px;">
  <form method="POST" action="/perpus/actions/borrow_book.php">
    <label>Peminjam (nama):</label><br><input type="text" name="peminjam" required><br>
    <label>Pilih Buku:</label><br>
    <select name="id_buku" required>
      <option value="">-- pilih --</option>
      <?php while($b = $books->fetch_assoc()): ?>
        <option value="<?= $b['id']; ?>"><?= htmlspecialchars($b['judul']).' (stok: '.intval($b['stok']).')'; ?></option>
      <?php endwhile; ?>
    </select><br><br>
    <button type="submit">Pinjamkan</button>
  </form>
</div>
<table>
  <tr><th>No</th><th>Peminjam</th><th>Judul Buku</th><th>Tgl Pinjam</th><th>Tgl Kembali</th><th>Status</th><th>Aksi</th></tr>
  <?php $no=1; while($r = $res->fetch_assoc()): ?>
  <tr>
    <td><?= $no++; ?></td>
    <td><?= htmlspecialchars($r['peminjam']); ?></td>
    <td><?= htmlspecialchars($r['judul']); ?></td>
    <td><?= htmlspecialchars($r['tanggal_pinjam']); ?></td>
    <td><?= htmlspecialchars($r['tanggal_kembali']); ?></td>
    <td><?= htmlspecialchars($r['status']); ?></td>
    <td>
      <?php if($r['status'] == 'Dipinjam'): ?>
        <a href="/perpus/actions/return_book.php?id=<?= $r['id']; ?>" onclick="return confirm('Proses pengembalian buku?')">Kembalikan</a>
      <?php else: ?>
        -
      <?php endif; ?>
    </td>
  </tr>
  <?php endwhile; ?>
</table>
<?php include __DIR__ . '/../includes/footer.php'; ?>