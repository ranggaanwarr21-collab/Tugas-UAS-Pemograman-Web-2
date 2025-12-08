<?php include __DIR__ . '/../includes/header.php'; ?>

<div class="container">
    <div class="page-header">
        <h2 class="page-title">Pendaftaran Member Perpustakaan</h2>
        <a href="/perpus/pages/member.php" class="back-btn">← Kembali</a>
    </div>

    <form method="POST" action="/perpus/actions/member_add_action.php">

        <label>Nama Lengkap:</label>
        <input type="text" name="nama" required>

        <label>NIS / NIK / ID Siswa:</label>
        <input type="text" name="nis" required>

        <label>No. Telepon:</label>
        <input type="text" name="telepon" required>

        <label>Alamat:</label>
        <textarea name="alamat" rows="3" required></textarea>

        <label>Jenis Kelamin:</label>
        <select name="gender" required>
            <option value="">-- Pilih --</option>
            <option value="L">Laki-Laki</option>
            <option value="P">Perempuan</option>
        </select>

        <button type="submit" class="btn">Daftarkan Member</button>
    </form>

</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
