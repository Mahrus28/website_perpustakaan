<?php
include '../config.php';

/* AMBIL DATA BUKU */
$data = mysqli_query($conn, "SELECT * FROM buku ORDER BY judul ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Katalog Buku</title>
<link rel="stylesheet" href="katalog.css">
</head>
<body>

<div class="container">

    <!-- HEADER -->
    <div class="header">
        <h2>📚 Katalog Buku</h2>
        <a href="dashboard.php" class="btn-back">⬅ Kembali</a>
    </div>

    <!-- KATALOG -->
    <div class="grid">
        <?php while($b = mysqli_fetch_assoc($data)): ?>
        <div class="card">
            <img src="../assets/cover/<?= $b['cover'] ?: 'default.png'; ?>" alt="cover">

            <div class="info">
                <h4><?= htmlspecialchars($b['judul']); ?></h4>
                <p class="penulis"><?= htmlspecialchars($b['penulis']); ?></p>
                <p class="tahun">Tahun: <?= $b['tahun']; ?></p>

                <?php if ($b['stok'] > 0): ?>
                    <span class="stok tersedia">Tersedia (<?= $b['stok']; ?>)</span>
                <?php else: ?>
                    <span class="stok habis">Stok Habis</span>
                <?php endif; ?>
            </div>
        </div>
        <?php endwhile; ?>
    </div>

</div>

</body>
</html>
