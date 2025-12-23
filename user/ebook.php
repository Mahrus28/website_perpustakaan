<?php
include '../config.php';

/* AMBIL DATA EBOOK */
$data = mysqli_query($conn, "SELECT * FROM ebook ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Katalog E-Book</title>
<link rel="stylesheet" href="ebook.css">
</head>
<body>

<div class="container">

    <!-- HEADER -->
    <div class="header">
        <h2>📘 Katalog E-Book</h2>
        <a href="dashboard.php" class="btn-back">⬅ Kembali</a>
    </div>

    <!-- GRID EBOOK -->
    <div class="grid">
        <?php while($e = mysqli_fetch_assoc($data)): ?>
        <div class="card">
            <img src="../assets/ebook/cover/<?= $e['cover'] ?: 'default.png'; ?>" alt="cover">

            <div class="info">
                <h4><?= htmlspecialchars($e['judul']); ?></h4>
                <p class="penulis"><?= htmlspecialchars($e['penulis']); ?></p>
                <p class="tahun">Tahun: <?= $e['tahun']; ?></p>
                <p class="desc"><?= substr($e['deskripsi'],0,80); ?>...</p>

                <?php if ($e['file']): ?>
                    <a href="../assets/ebook/<?= $e['file']; ?>" target="_blank" class="btn">
                        📥 Baca / Download
                    </a>
                <?php else: ?>
                    <span class="btn disabled">File tidak tersedia</span>
                <?php endif; ?>
            </div>
        </div>
        <?php endwhile; ?>
    </div>

</div>

</body>
</html>
