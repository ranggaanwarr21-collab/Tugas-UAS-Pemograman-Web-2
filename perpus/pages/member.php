<?php 
require_once __DIR__ . '/../includes/config.php'; 
include __DIR__ . '/../includes/header.php'; 

if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION['admin_logged'])) { 
    header('Location: /perpus/pages/login.php'); 
    exit; 
}

$res = $conn->query("SELECT * FROM members ORDER BY id DESC");
?>

<div class="container">

    <div class="page-header">
        <h2 class="page-title">Daftar Member Perpustakaan</h2>
        <a href="/perpus/pages/member_add.php" class="btn">+ Tambah Member</a>
    </div>

    <table>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>NIS / NIK</th>
            <th>Telepon</th>
            <th>Alamat</th>
            <th>Gender</th>
            <th>Tanggal Daftar</th>
            <th>Aksi</th>
        </tr>

        <?php 
        $no = 1;
        while ($m = $res->fetch_assoc()):
        ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($m['nama']); ?></td>
            <td><?= htmlspecialchars($m['nis']); ?></td>
            <td><?= htmlspecialchars($m['telepon']); ?></td>
            <td><?= htmlspecialchars($m['alamat']); ?></td>
            <td><?= $m['gender'] === 'L' ? 'Laki-Laki' : 'Perempuan'; ?></td>
            <td><?= $m['created_at']; ?></td>

            <td>
                <a href="/perpus/pages/member_edit.php?id=<?= $m['id']; ?>" class="btn">Edit</a>
                <a href="/perpus/actions/member_delete_action.php?id=<?= $m['id']; ?>" 
                   class="btn-danger"
                   onclick="return confirm('Hapus member ini?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
