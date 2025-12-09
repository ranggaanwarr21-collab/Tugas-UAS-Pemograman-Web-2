<?php 
require_once __DIR__ . '/../includes/config.php'; 
include __DIR__ . '/../includes/header.php'; 

if (!isset($_GET['id'])) {
    header("Location: /perpus/pages/member.php");
    exit;
}

$id = intval($_GET['id']);
$member = $conn->query("SELECT * FROM members WHERE id = $id")->fetch_assoc();
?>

<div class="container">

    <div class="page-header">
        <h2 class="page-title">Edit Member</h2>
        <a href="/perpus/pages/member.php" class="back-btn">← Kembali</a>
    </div>

    <form method="POST" action="/perpus/actions/member_update_action.php">

        <input type="hidden" name="id" value="<?= $member['id']; ?>">

        <label>Nama Lengkap:</label>
        <input type="text" name="nama" value="<?= $member['nama']; ?>" required>

        <label>NIS / NIK:</label>
        <input type="text" name="nis" value="<?= $member['nis']; ?>" required>

        <label>Telepon:</label>
        <input type="text" name="telepon" value="<?= $member['telepon']; ?>" required>

        <label>Alamat:</label>
        <textarea name="alamat" required><?= $member['alamat']; ?></textarea>

        <label>Jenis Kelamin:</label>
        <select name="gender" required>
            <option value="L" <?= $member['gender'] === 'L' ? 'selected' : '' ?>>Laki-Laki</option>
            <option value="P" <?= $member['gender'] === 'P' ? 'selected' : '' ?>>Perempuan</option>
        </select>

        <button type="submit" class="btn">Update Member</button>

    </form>

</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
