<?php 
require_once __DIR__ . '/../includes/config.php'; 
include __DIR__ . '/../includes/header.php';

if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION['admin_logged'])) { 
    header('Location: /perpus/pages/login.php'); 
    exit; 
}

// Ambil Data Peminjaman
$res = $conn->query("
    SELECT p.*, b.judul 
    FROM peminjaman p 
    JOIN buku b ON p.id_buku = b.id 
    ORDER BY p.id DESC
");

// Ambil Data Buku (hanya stok > 0)
$books = $conn->query("
    SELECT id, judul, stok 
    FROM buku 
    WHERE stok > 0 
    ORDER BY judul ASC
");
?>

<div class="container">

    <div class="page-header">
        <h2 class="page-title">📖 Data Peminjaman Buku</h2>
        <a href="/perpus/pages/dashboard.php" class="btn back-btn">← Kembali</a>
    </div>

    <!-- Tombol Tambah -->
    <div style="text-align:right; margin-bottom:20px;">
        <button class="btn" onclick="openModal()">+ Tambah Peminjaman</button>
    </div>

    <!-- Modal Tambah Peminjaman -->
    <div id="modalPinjam" class="modal-bg">
        <div class="modal-box">
            <h3>Tambah Peminjaman Baru</h3>

            <form method="POST" action="/perpus/actions/borrow_book.php">

                <label>Nama Peminjam:</label>
                <input type="text" name="peminjam" required>

                <label>Pilih Buku:</label>
                <select name="id_buku" required>
                    <option value="">-- pilih buku --</option>
                    <?php while($b = $books->fetch_assoc()): ?>
                        <option value="<?= $b['id']; ?>">
                            <?= htmlspecialchars($b['judul']) . " (stok: " . intval($b['stok']) . ")"; ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <div style="text-align:right; margin-top:10px;">
                    <button type="button" class="btn btn-danger" onclick="closeModal()">Batal</button>
                    <button type="submit" class="btn">Pinjam</button>
                </div>

            </form>
        </div>
    </div>

    <!-- Tabel Data -->
    <table class="modern-table">
        <tr>
            <th>No</th>
            <th>Peminjam</th>
            <th>Judul Buku</th>
            <th>Tgl Pinjam</th>
            <th>Tgl Kembali</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>

        <?php 
        $no = 1;
        while($r = $res->fetch_assoc()): 
        ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($r['peminjam']); ?></td>
            <td><?= htmlspecialchars($r['judul']); ?></td>
            <td><?= htmlspecialchars($r['tanggal_pinjam']); ?></td>
            <td><?= htmlspecialchars($r['tanggal_kembali']); ?></td>

            <td>
                <?= ($r['status'] == 'Dipinjam') 
                    ? "<span style='color:#d00000;font-weight:600;'>Dipinjam</span>" 
                    : "<span style='color:green;font-weight:600;'>Kembali</span>" ?>
            </td>

            <td>
                <?php if($r['status'] === "Dipinjam"): ?>
                    <a href="/perpus/actions/return_book.php?id=<?= $r['id']; ?>" 
                       class="btn btn-danger" 
                       onclick="return confirm('Proses pengembalian buku?')">
                        Kembalikan
                    </a>
                <?php else: ?>
                    <span style="opacity:0.5;">—</span>
                <?php endif; ?>
            </td>

        </tr>
        <?php endwhile; ?>

    </table>

</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>

<!-- Modal Script -->
<script>
function openModal() {
    document.getElementById('modalPinjam').style.display = 'flex';
}
function closeModal() {
    document.getElementById('modalPinjam').style.display = 'none';
}
</script>

<style>
/* Modal Background */
.modal-bg {
    display: none;
    justify-content: center;
    align-items: center;
    position: fixed;
    top:0; left:0;
    width:100%; height:100%;
    background: rgba(0,0,0,0.45);
    backdrop-filter: blur(3px);
    z-index: 999;
}

/* Modal Box */
.modal-box {
    background:#fff;
    padding:25px;
    width:420px;
    border-radius:12px;
    box-shadow:0 5px 20px rgba(0,0,0,0.2);
    animation: fadeIn 0.3s ease;
}

.modal-box h3 {
    margin-bottom:15px;
    font-size:20px;
    font-weight:600;
}

/* Modern Table */
.modern-table th {
    background:#1a73e8;
    color:white;
}

.modern-table tr:nth-child(even) {
    background:#eef3ff;
}

.modern-table tr:hover {
    background:#dce8ff;
    transition:0.2s;
}
</style>
