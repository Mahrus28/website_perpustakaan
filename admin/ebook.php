<?php
session_start();
include '../config.php';

if (!isset($_SESSION['login']) || $_SESSION['role']!='admin') {
    header("Location: ../auth/login.php");
    exit;
}

/* TAMBAH */
if (isset($_POST['tambah'])) {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $tahun = $_POST['tahun'];
    $deskripsi = $_POST['deskripsi'];

    /* FILE PDF */
    $file = null;
    if (!empty($_FILES['file']['name'])) {
        $file = uniqid().'_'.$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], "../assets/ebook/".$file);
    }

    /* COVER */
    $cover = null;
    if (!empty($_FILES['cover']['name'])) {
        $cover = uniqid().'_'.$_FILES['cover']['name'];
        move_uploaded_file($_FILES['cover']['tmp_name'], "../assets/ebook/cover/".$cover);
    }

    mysqli_query($conn,"
        INSERT INTO ebook (judul,penulis,tahun,deskripsi,file,cover)
        VALUES ('$judul','$penulis','$tahun','$deskripsi','$file','$cover')
    ");

    header("Location: ebook.php");
}

/* HAPUS */
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $e = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM ebook WHERE id_ebook='$id'"));

    if ($e['file']) unlink("../assets/ebook/".$e['file']);
    if ($e['cover']) unlink("../assets/ebook/cover/".$e['cover']);

    mysqli_query($conn,"DELETE FROM ebook WHERE id_ebook='$id'");
    header("Location: ebook.php");
}

/* DATA */
$data = mysqli_query($conn,"SELECT * FROM ebook ORDER BY id_ebook DESC");
?>
<!DOCTYPE html>
<html>
<head>
<title>Kelola E-Book</title>
<link rel="stylesheet" href="ebook.css">
</head>
<body>

<div class="container">
<h2>📘 Kelola E-Book</h2>

<form method="post" enctype="multipart/form-data" class="card">
    <input name="judul" placeholder="Judul E-Book" required>
    <input name="penulis" placeholder="Penulis" required>
    <input type="number" name="tahun" placeholder="Tahun" required>
    <textarea name="deskripsi" placeholder="Deskripsi"></textarea>

    <label>📄 File PDF</label>
    <input type="file" name="file" accept=".pdf">

    <label>🖼 Cover</label>
    <input type="file" name="cover" accept="image/*">

    <button name="tambah">➕ Tambah E-Book</button>
</form>

<table class="table">
<tr>
    <th>No</th>
    <th>Cover</th>
    <th>Judul</th>
    <th>Penulis</th>
    <th>Tahun</th>
    <th>Aksi</th>
</tr>
<?php $no=1; while($e=mysqli_fetch_assoc($data)): ?>
<tr>
    <td><?= $no++; ?></td>
    <td><img src="../assets/ebook/cover/<?= $e['cover'] ?: 'default.png'; ?>" class="thumb"></td>
    <td><?= $e['judul']; ?></td>
    <td><?= $e['penulis']; ?></td>
    <td><?= $e['tahun']; ?></td>
    <td>
        <a href="edit_ebook.php?id=<?= $e['id_ebook']; ?>" class="btn edit">Edit</a>
        <a href="?hapus=<?= $e['id_ebook']; ?>" class="btn hapus"
           onclick="return confirm('Hapus ebook ini?')">Hapus</a>
    </td>
</tr>
<?php endwhile; ?>
</table>
</div>

</body>
</html>
