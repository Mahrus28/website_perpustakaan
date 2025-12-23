<?php
session_start();
include '../config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

/* ======================
   DATA BUKU (DROPDOWN)
====================== */
$bukuList = mysqli_query($conn, "SELECT judul FROM buku ORDER BY judul ASC");

/* ======================
   TAMBAH PINJAMAN
====================== */
if (isset($_POST['tambah'])) {
    $nama        = $_POST['nama'];
    $buku        = $_POST['buku'];
    $tgl_pinjam  = $_POST['tgl_pinjam'];
    $tgl_kembali = $_POST['tgl_kembali'] ?: NULL;

    mysqli_query($conn,"
        INSERT INTO peminjaman
        (nama_peminjam, judul_buku, tanggal_pinjam, tanggal_kembali)
        VALUES
        ('$nama','$buku','$tgl_pinjam','$tgl_kembali')
    ");

    header("Location: peminjaman.php");
    exit;
}

/* ======================
   KONFIRMASI KEMBALI
====================== */
if (isset($_GET['kembali'])) {
    $id = $_GET['kembali'];

    $q = mysqli_query($conn,"
        SELECT DATEDIFF(CURDATE(), tanggal_pinjam) AS hari
        FROM peminjaman WHERE id_pinjam='$id'
    ");

    $d = mysqli_fetch_assoc($q);
    $hari = $d['hari'] ?? 0;
    $denda = max(0, ($hari - 7) * 1000);

    mysqli_query($conn,"
        UPDATE peminjaman SET
        status='kembali',
        tanggal_kembali=CURDATE(),
        denda='$denda'
        WHERE id_pinjam='$id'
    ");

    header("Location: peminjaman.php");
    exit;
}

/* ======================
   KONFIRMASI HILANG
====================== */
if (isset($_GET['hilang'])) {
    $id = $_GET['hilang'];

    mysqli_query($conn,"
        UPDATE peminjaman SET
        status='hilang',
        denda=50000
        WHERE id_pinjam='$id'
    ");

    header("Location: peminjaman.php");
    exit;
}

/* ======================
   DATA PINJAMAN
====================== */
$data = mysqli_query($conn,"SELECT * FROM peminjaman ORDER BY id_pinjam DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Kelola Peminjaman</title>
<link rel="stylesheet" href="peminjaman.css">
</head>
<body>

<div class="container">

<a href="dashboard.php" class="btn-back">⬅ Dashboard</a>

<h2>📦 Kelola Peminjaman Buku</h2>

<!-- FORM PINJAMAN -->
<form method="post" class="form-pinjaman">
    <input type="text" name="nama" placeholder="Nama Peminjam" required>

    <select name="buku" required>
        <option value="">-- Pilih Buku --</option>
        <?php
        $bukuList = mysqli_query($conn, "SELECT judul FROM buku ORDER BY judul ASC");
        while($b = mysqli_fetch_assoc($bukuList)):
        ?>
            <option value="<?= $b['judul']; ?>">
                <?= $b['judul']; ?>
            </option>
        <?php endwhile; ?>
    </select>

    <input type="date" name="tgl_pinjam" required>
    <input type="date" name="tgl_kembali">

    <button type="submit" name="tambah">
        ➕ Tambah Pinjaman
    </button>
</form>

<!-- TABEL -->
<table class="table">
<thead>
<tr>
    <th>No</th>
    <th>Nama</th>
    <th>Buku</th>
    <th>Tgl Pinjam</th>
    <th>Tgl Kembali</th>
    <th>Status</th>
    <th>Denda</th>
    <th>Aksi</th>
</tr>
</thead>
<tbody>
<?php $no=1; while($p=mysqli_fetch_assoc($data)): ?>
<tr>
    <td><?= $no++; ?></td>
    <td><?= htmlspecialchars($p['nama_peminjam']); ?></td>
    <td><?= htmlspecialchars($p['judul_buku']); ?></td>
    <td><?= $p['tanggal_pinjam']; ?></td>
    <td><?= $p['tanggal_kembali'] ?: '-'; ?></td>
    <td>
        <span class="status <?= $p['status']; ?>">
            <?= ucfirst($p['status']); ?>
        </span>
    </td>
    <td>Rp <?= number_format($p['denda']); ?></td>
    <td>
        <?php if ($p['status']=='dipinjam'): ?>
        <div class="aksi">
            <a href="?kembali=<?= $p['id_pinjam']; ?>" class="btn kembali">Kembali</a>
            <a href="?hilang=<?= $p['id_pinjam']; ?>" class="btn hilang">Hilang</a>
        </div>
        <?php else: ?> -
        <?php endif; ?>
    </td>
</tr>
<?php endwhile; ?>
</tbody>
</table>

</div>

<script>
function filterBuku(input) {
    const filter = input.value.toLowerCase();
    const select = input.nextElementSibling;
    const options = select.options;

    for (let i = 1; i < options.length; i++) {
        const text = options[i].text.toLowerCase();
        options[i].style.display = text.includes(filter) ? '' : 'none';
    }
}
</script>

</body>
</html>
