<?php 
require_once __DIR__ . '/../includes/config.php'; 
include __DIR__ . '/../includes/header.php';

if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION['admin_logged'])) { 
    header('Location: /perpus/pages/login.php'); 
    exit; 
}

$res = $conn->query("SELECT * FROM buku ORDER BY id DESC");
?>

<div class="container">

    <div class="page-header">
        <h2 class="page-title">📚 Data Buku</h2>
        <a href="/perpus/pages/dashboard.php" class="btn back-btn">← Kembali</a>
    </div>

    <!-- Tombol Tambah -->
    <div style="text-align:right; margin-bottom:20px;">
        <button class="btn" onclick="openModal()">+ Tambah Buku</button>
    </div>

    <!-- Modal Tambah Buku -->
    <div id="modalAdd" class="modal-bg">
        <div class="modal-box">
            <h3>Tambah Buku Baru</h3>

            <form method="POST" action="/perpus/actions/add_book.php" enctype="multipart/form-data">
                
                <label>Gambar Buku (Cover):</label>
                <input type="file" name="cover" accept="image/*">

                <label>Judul Buku:</label>
                <input type="text" name="judul" required>

                <label>Penulis:</label>
                <input type="text" name="penulis">

                <label>Penerbit:</label>
                <input type="text" name="penerbit">

                <label>Tahun Terbit:</label>
                <input type="number" name="tahun">

                <label>Stok Buku:</label>
                <input type="number" name="stok" value="1" min="1">

                <div style="text-align:right; margin-top:10px;">
                    <button type="button" class="btn btn-danger" onclick="closeModal()">Batal</button>
                    <button type="submit" class="btn">Simpan</button>
                </div>

            </form>
        </div>
    </div>

    <!-- Modal Edit Buku -->
<div id="modalEdit" class="modal-bg">
    <div class="modal-box">
        <h3>Edit Buku</h3>

        <form method="POST" action="/perpus/actions/edit_book.php" enctype="multipart/form-data">

            <input type="hidden" name="id" id="edit_id">

            <label>Gambar Buku (Cover Baru - optional):</label>
            <input type="file" name="cover" accept="image/*">

            <label>Judul Buku:</label>
            <input type="text" name="judul" id="edit_judul" required>

            <label>Penulis:</label>
            <input type="text" name="penulis" id="edit_penulis">

            <label>Penerbit:</label>
            <input type="text" name="penerbit" id="edit_penerbit">

            <label>Tahun Terbit:</label>
            <input type="number" name="tahun" id="edit_tahun">

            <label>Stok Buku:</label>
            <input type="number" name="stok" id="edit_stok" min="1">

            <div style="text-align:right; margin-top:10px;">
                <button type="button" class="btn btn-danger" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="btn">Update</button>
            </div>

        </form>
    </div>
</div>

    <!-- Tabel Buku -->
    <table class="modern-table">
        <tr>
            <th>No</th>
            <th>Cover</th>
            <th>Judul</th>
            <th>Penulis</th>
            <th>Penerbit</th>
            <th>Tahun</th>
            <th>Stok</th>
            <th>Aksi</th>
            <th>Kelola</th>
        </tr>

        <?php 
        $no = 1; 
        while ($r = $res->fetch_assoc()): 
            $img = (!empty($r['cover'])) 
                    ? "/perpus/uploads/buku/" . $r['cover']
                    : "/perpus/assets/default_book.png";  // gambar default
        ?>
        <tr>
            <td><?= $no++; ?></td>

            <!-- Cover Buku -->
            <td>
                <img src="<?= $img ?>" class="cover-img">
            </td>

            <td><?= htmlspecialchars($r['judul']); ?></td>
            <td><?= htmlspecialchars($r['penulis']); ?></td>
            <td><?= htmlspecialchars($r['penerbit']); ?></td>
            <td><?= htmlspecialchars($r['tahun_terbit']); ?></td>
            <td><?= htmlspecialchars($r['stok']); ?></td>

            <td>
                <a href="/perpus/actions/return_book.php?id=<?= $r['id']; ?>" 
                   class="btn btn-danger" 
                   onclick="return confirm('Yakin tandai dikembalikan?')">
                    Tandai Kembali
                </a>
            </td>

            <td>

    <!-- Tombol Edit -->
    <button class="btn btn-edit" onclick="openEditModal(
        '<?= $r['id'] ?>',
        '<?= htmlspecialchars($r['judul']) ?>',
        '<?= htmlspecialchars($r['penulis']) ?>',
        '<?= htmlspecialchars($r['penerbit']) ?>',
        '<?= htmlspecialchars($r['tahun_terbit']) ?>',
        '<?= htmlspecialchars($r['stok']) ?>'
    )">Edit</button>

    <!-- Tombol Hapus -->
    <a href="/perpus/actions/delete_book.php?id=<?= $r['id']; ?>" 
       class="btn btn-danger"
       onclick="return confirm('Hapus buku ini?')">
       Hapus
    </a>

</td>

        </tr>
        <?php endwhile; ?>

    </table>

</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>

<script>
function openModal() {
    document.getElementById('modalAdd').style.display = 'flex';
}
function closeModal() {
    document.getElementById('modalAdd').style.display = 'none';
}
</script>

<style>
/* Gambar Cover Buku */
.cover-img {
    width: 55px;
    height: 75px;
    border-radius: 6px;
    object-fit: cover;
    box-shadow: 0px 2px 6px rgba(0,0,0,0.2);
}

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

/* Box Modal */
.modal-box {
    background:#fff;
    padding:25px;
    width: 420px;
    border-radius:12px;
    box-shadow:0 5px 20px rgba(0,0,0,0.2);
    animation: fadeIn 0.3s ease;
}

.modal-box h3 {
    margin-bottom:15px;
    font-size:20px;
    font-weight:600;
}

/* Table Modern */
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
