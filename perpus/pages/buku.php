<?php require_once __DIR__ . '/../includes/config.php'; include __DIR__ . '/../includes/header.php'; 
if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION['admin_logged'])) { header('Location: /perpus/pages/login.php'); exit; }
$res = $conn->query('SELECT * FROM buku ORDER BY id DESC');
?>
<h2>Data Buku</h2>
<a href="/perpus/pages/dashboard.php">&larr; Kembali</a>
<div style="margin:15px 0;">
  <button onclick="document.getElementById('formAdd').style.display='block'">+ Tambah Buku</button>
</div>
<div id="formAdd" style="display:none; background:#fff; padding:15px; width:90%; margin:0 auto 20px; border-radius:6px;">
  <form method="POST" action="/perpus/actions/add_book.php">
    <label>Judul:</label><br><input type="text" name="judul" required><br>
    <label>Penulis:</label><br><input type="text" name="penulis"><br>
    <label>Penerbit:</label><br><input type="text" name="penerbit"><br>
    <label>Tahun Terbit:</label><br><input type="number" name="tahun"><br>
    <label>Stok:</label><br><input type="number" name="stok" value="1"><br><br>
    <button type="submit">Simpan</button>
  </form>
</div>
<table>
  <tr><th>No</th><th>Judul</th><th>Penulis</th><th>Penerbit</th><th>Tahun</th><th>Stok</th><th>Aksi</th></tr>
  <?php $no=1; while($r = $res->fetch_assoc()): ?>
  <tr>
    <td><?= $no++; ?></td>
    <td><?= htmlspecialchars($r['judul']); ?></td>
    <td><?= htmlspecialchars($r['penulis']); ?></td>
    <td><?= htmlspecialchars($r['penerbit']); ?></td>
    <td><?= htmlspecialchars($r['tahun_terbit']); ?></td>
    <td><?= htmlspecialchars($r['stok']); ?></td>
    <td>
      <a href="/perpus/actions/return_book.php?id=<?= $r['id']; ?>" onclick="return confirm('Tandai dikembalikan? (Hanya jika ini adalah transaksi)')">Tandai Kembali</a>
    </td>
  </tr>
  <?php endwhile; ?>
</table>
<?php include __DIR__ . '/../includes/footer.php'; ?>