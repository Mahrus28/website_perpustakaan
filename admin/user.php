<?php
session_start();
include '../config.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$data = mysqli_query($conn, "SELECT * FROM users WHERE role='user' ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Kelola User</title>
<link rel="stylesheet" href="user.css">
</head>
<body>

<div class="navbar">
    <div class="logo">👥 Kelola User</div>
    <a href="dashboard.php" class="back">⬅ Dashboard</a>
</div>

<div class="container">

    <div class="header">
        <h2>Daftar User</h2>
        <a href="user_tambah.php" class="btn-add">➕ Tambah User</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php $no=1; while($u = mysqli_fetch_assoc($data)): ?>
    <tr>
    <td><?= $no++; ?></td>
    <td><?= htmlspecialchars($u['nama']); ?></td>
    <td><?= htmlspecialchars($u['username']); ?></td>
    <td>
        <a href="user_hapus.php?id=<?= $u['id_user']; ?>"
           onclick="return confirm('Hapus user ini?')"
           class="btn-delete">
           Hapus
        </a>
    </td>
    </tr>
<?php endwhile; ?>
        </tbody>
    </table>

</div>

</body>
</html>
