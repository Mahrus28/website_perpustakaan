<?php
session_start();
include '../config.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'user') {
    header("Location: ../auth/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard User</title>
<link rel="stylesheet" href="dashboard.css">
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
    <div class="logo">📚 Perpustakaan Digital</div>
    <div class="nav-right">
        <span class="user-name">👤 <?= $_SESSION['nama']; ?></span>
        <a href="../auth/logout.php" class="logout">Logout</a>
    </div>
</div>

<!-- CONTENT -->
<div class="container">
    <?php
$event = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT * FROM events 
     WHERE status='aktif' 
     AND CURDATE() BETWEEN tanggal_mulai AND tanggal_selesai 
     ORDER BY created_at DESC LIMIT 1"
));
?>

<?php if($event): ?>
<div class="event-banner">
    <div class="banner-wrapper">
        <div class="event-banner">
            <div class="event-icon">📢</div>
            <div class="event-content">
                <h4>Pengumuman</h4>
                <ul>
                    <li>🕒 Jam layanan: Senin – Jumat (08.00 – 16.00)</li>
                    <li>📚 Maksimal peminjaman 3 buku</li>
                    <li>⚠️ Keterlambatan dikenakan denda</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

    <!-- BANNER PENGUMUMAN -->
    <div class="announcement">
        <div class="announcement-icon">📢</div>
            <div class="announcement-text">
            <h4>Pengumuman</h4>
            <p>
            📅 Jam layanan perpustakaan: <b>Senin – Jumat (08.00 – 16.00)</b><br>
            📚 Maksimal peminjaman <b>3 buku</b><br>
            ⚠️ Keterlambatan pengembalian dikenakan <b>denda</b>
            </p>
        </div>
    </div>


    <h2>Dashboard User</h2>
    <p class="subtitle">Selamat datang di perpustakaan digital</p>

    <div class="menu-grid">

        <a href="katalog.php" class="menu-card">
            <div class="icon">📚</div>
            <h3>Katalog Buku</h3>
            <p>Lihat koleksi buku perpustakaan</p>
        </a>

        <a href="ebook.php" class="menu-card">
            <div class="icon">📘</div>
            <h3>E-Book</h3>
            <p>Baca buku digital kapan saja</p>
        </a>

    </div>

</div>

</body>
</html>
