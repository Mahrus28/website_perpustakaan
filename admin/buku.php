<?php
session_start();
include '../config.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}


// TOTAL JUDUL BUKU
$qJudul = mysqli_query($conn, "SELECT COUNT(*) AS total_judul FROM buku");
$totalJudul = mysqli_fetch_assoc($qJudul)['total_judul'];

// TOTAL STOK BUKU
$qStok = mysqli_query($conn, "SELECT SUM(stok) AS total_stok FROM buku");
$totalStok = mysqli_fetch_assoc($qStok)['total_stok'] ?? 0;

// BUKU HABIS
$qHabis = mysqli_query($conn, "SELECT COUNT(*) AS habis FROM buku WHERE stok=0");
$totalHabis = mysqli_fetch_assoc($qHabis)['habis'];


/* TAMBAH BUKU + UPLOAD COVER */
if (isset($_POST['tambah'])) {

    $judul     = $_POST['judul'];
    $penulis   = $_POST['penulis'];
    $penerbit  = $_POST['penerbit'];
    $tahun     = $_POST['tahun'];
    $stok      = $_POST['stok'];
    $deskripsi = $_POST['deskripsi'];

    /* UPLOAD COVER */
    $coverName = null;

    if (!empty($_FILES['cover']['name'])) {
        $ext = strtolower(pathinfo($_FILES['cover']['name'], PATHINFO_EXTENSION));
        $allow = ['jpg','jpeg','png','webp'];

        if (in_array($ext, $allow)) {
            $coverName = uniqid().'_'.$ext;
            move_uploaded_file(
                $_FILES['cover']['tmp_name'],
                "../assets/cover/".$coverName
            );
        }
    }

    mysqli_query($conn,
        "INSERT INTO buku (judul,penulis,penerbit,tahun,stok,deskripsi,cover)
         VALUES (
            '$judul','$penulis','$penerbit','$tahun','$stok','$deskripsi','$coverName'
         )"
    );

    header("Location: buku.php");
    exit;
}

/* HAPUS */
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];

    // hapus cover file
    $q = mysqli_fetch_assoc(mysqli_query($conn,"SELECT cover FROM buku WHERE id_buku='$id'"));
    if ($q['cover']) {
        unlink("../assets/cover/".$q['cover']);
    }

    mysqli_query($conn,"DELETE FROM buku WHERE id_buku='$id'");
    header("Location: buku.php");
    exit;
}

/* DATA */
$data = mysqli_query($conn,"SELECT * FROM buku ORDER BY id_buku DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Buku</title>
<link rel="stylesheet" href="buku.css">
</head>
<body>

<div class="container">
<div class="top-bar">
    <a href="dashboard.php" class="btn-back">⬅ Dashboard</a>
</div>

<h2>📚 Tambah Buku</h2>

<!-- FORM -->
<form method="post" enctype="multipart/form-data" class="card">
    <input name="judul" placeholder="Judul Buku" required>
    <input name="penulis" placeholder="Penulis" required>
    <input name="penerbit" placeholder="Penerbit" required>
    <input type="number" name="tahun" placeholder="Tahun" required>
    <input type="number" name="stok" placeholder="Stok" required>
    <textarea name="deskripsi" placeholder="Deskripsi Buku"></textarea>

    <label class="upload">
        📷 Upload Cover
        <input type="file" name="cover" accept="image/*">
    </label>

    <button name="tambah">➕ Tambah Buku</button>
</form>

<div class="card">
<h3>📚 Data Buku</h3>

<table class="table">
<thead>
<tr>
    <th>No</th>
    <th>Cover</th>
    <th>Judul</th>
    <th>Penulis</th>
    <th>Tahun</th>
    <th>Stok</th>
    <th>Aksi</th>
</tr>
</thead>
<tbody>
<?php $no=1; while($b=mysqli_fetch_assoc($data)): ?>
<tr>
    <td><?= $no++; ?></td>
    <td>
        <img src="../upload/cover/<?= $b['cover'] ?: 'default.jpg'; ?>" class="thumb">
    </td>
    <td><?= htmlspecialchars($b['judul']); ?></td>
    <td><?= htmlspecialchars($b['penulis']); ?></td>
    <td><?= $b['tahun']; ?></td>
    <td>
        <span class="<?= $b['stok']==0?'stok-habis':'stok-ada'; ?>">
            <?= $b['stok']; ?>
        </span>
    </td>
    <td>
        <a href="edit_buku.php?id=<?= $b['id_buku']; ?>" class="btn edit">Edit</a>
        <a href="?hapus=<?= $b['id_buku']; ?>"
           onclick="return confirm('Yakin hapus buku ini?')"
           class="btn hapus">Hapus</a>
    </td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
</div>



</div>
</body>
</html>
