<?php
session_start();
include '../config.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

/* =========================
   KONFIRMASI KEMBALI
========================= */
if (isset($_GET['kembali'])) {
    $id = $_GET['kembali'];

    $q = mysqli_query($conn,"
        SELECT DATEDIFF(CURDATE(), tanggal_pinjam) AS hari
        FROM peminjaman
        WHERE id_pinjam='$id'
    ");

    if (!$q) {
        die("Query error: " . mysqli_error($conn));
    }

    $data = mysqli_fetch_assoc($q);
    $hari = $data['hari'] ?? 0;

    // aturan denda
    $denda = max(0, ($hari - 7) * 1000);

    mysqli_query($conn,"
        UPDATE peminjaman SET
        status='kembali',
        tanggal_kembali=CURDATE(),
        denda='$denda'
        WHERE id_pinjam='$id'
    ");

    header("Location: kembali.php");
    exit;
}

/* =========================
   DATA PINJAMAN AKTIF
========================= */
$result = mysqli_query($conn,"
    SELECT * FROM peminjaman
    WHERE status='dipinjam'
    ORDER BY tanggal_pinjam ASC
");

if (!$result) {
    die("Query error: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Konfirmasi Buku Kembali</title>
<link rel="stylesheet" href="kembali.css">
</head>
<body>

<div class="container">

<a href="dashboard.php" class="btn-back">⬅ Dashboard</a>

<h2>📥 Konfirmasi Buku Kembali</h2>

<table class="table">
<thead>
<tr>
    <th>No</th>
    <th>Nama Peminjam</th>
    <th>Judul Buku</th>
    <th>Tanggal Pinjam</th>
    <th>Lama (Hari)</th>
    <th>Aksi</th>
</tr>
</thead>
<tbody>
<?php
$no = 1;
while ($p = mysqli_fetch_assoc($result)):

    $hari = (strtotime(date('Y-m-d')) - strtotime($p['tanggal_pinjam'])) / 86400;
?>
<tr>
    <td><?= $no++; ?></td>
    <td><?= htmlspecialchars($p['nama_peminjam']); ?></td>
    <td><?= htmlspecialchars($p['judul_buku']); ?></td>
    <td><?= $p['tanggal_pinjam']; ?></td>
    <td><?= floor($hari); ?> hari</td>
    <td>
        <a href="?kembali=<?= $p['id_pinjam']; ?>"
           class="btn kembali"
           onclick="return confirm('Konfirmasi buku sudah dikembalikan?')">
           ✔ Kembali
        </a>
    </td>
</tr>
<?php endwhile; ?>
</tbody>
</table>

</div>

</body>
</html>
