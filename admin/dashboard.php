<?php
session_start();
include '../config.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}
?>

<?php

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

/* === STATISTIK === */

// Total stok buku
$q_stok = mysqli_fetch_assoc(mysqli_query(
    $conn, "SELECT SUM(stok) AS total FROM buku"
));

// Buku dipinjam
$q_dipinjam = mysqli_fetch_assoc(mysqli_query(
    $conn, "SELECT COUNT(*) AS total FROM peminjaman WHERE status='dipinjam'"
));

// Buku dikembalikan
$q_kembali = mysqli_fetch_assoc(mysqli_query(
    $conn, "SELECT COUNT(*) AS total FROM peminjaman WHERE status='kembali'"
));

// Total e-book
$q_ebook = mysqli_fetch_assoc(mysqli_query(
    $conn, "SELECT COUNT(*) AS total FROM ebook"
));

// Total denda
$q_denda = mysqli_fetch_assoc(mysqli_query(
    $conn, "SELECT SUM(denda) AS total FROM peminjaman"
));
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Admin</title>
<link rel="stylesheet" href="dashboard.css">
</head>
<body>

<div class="dashboard">

    <!-- HEADER -->
    <div class="header">
        <h2>📊 Dashboard Admin</h2>
        <a href="../auth/logout.php" class="logout">Logout</a>
    </div>

    <!-- INFO -->
    <p class="subtitle">Selamat datang, <b><?= $_SESSION['nama']; ?></b></p>
    
    
<div class="stats-grid">

    <div class="stat-card blue">
        <h3><?= $q_stok['total'] ?? 0; ?></h3>
        <p>Stok Buku</p>
    </div>

    <div class="stat-card orange">
        <h3><?= $q_dipinjam['total'] ?? 0; ?></h3>
        <p>Buku Dipinjam</p>
    </div>

    <div class="stat-card green">
        <h3><?= $q_kembali['total'] ?? 0; ?></h3>
        <p>Buku Dikembalikan</p>
    </div>

    <div class="stat-card purple">
        <h3><?= $q_ebook['total'] ?? 0; ?></h3>
        <p>Total E-Book</p>
    </div>

    <div class="stat-card red">
        <h3>Rp <?= number_format($q_denda['total'] ?? 0); ?></h3>
        <p>Total Denda</p>
    </div>

</div>

    <!-- MENU -->
    <div class="menu-grid">

        <a href="buku.php" class="menu-card">
            <span class="icon">📚</span>
            <h3>Buku</h3>
            <p>Kelola buku</p>
        </a>

        <a href="ebook.php" class="menu-card">
            <span class="icon">📘</span>
            <h3>E-Book</h3>
            <p>Kelola buku digital</p>
        </a>

        <a href="user.php" class="menu-card">
            <span class="icon">👥</span>
            <h3>User</h3>
            <p>Kelola pengguna</p>
        </a>

        <a href="peminjaman.php" class="menu-card">
            <span class="icon">📄</span>
            <h3>Peminjaman</h3>
            <p>Kelola peminjaman</p>
        </a>

    </div>

</div>

</body>
</html>
