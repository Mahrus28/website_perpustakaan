<?php
session_start();
include '../config.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$id = $_GET['id'];
$buku = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT * FROM buku WHERE id_buku='$id'")
);

if (isset($_POST['update'])) {
    $judul     = $_POST['judul'];
    $penulis   = $_POST['penulis'];
    $penerbit  = $_POST['penerbit'];
    $tahun     = $_POST['tahun'];
    $stok      = $_POST['stok'];
    $deskripsi = $_POST['deskripsi'];

    $cover = $buku['cover'];

    if (!empty($_FILES['cover']['name'])) {
        if ($cover) unlink("../assets/cover/".$cover);

        $ext = pathinfo($_FILES['cover']['name'], PATHINFO_EXTENSION);
        $cover = uniqid().'.'.$ext;
        move_uploaded_file($_FILES['cover']['tmp_name'], "../assets/cover/".$cover);
    }

    mysqli_query($conn,"
        UPDATE buku SET
        judul='$judul',
        penulis='$penulis',
        penerbit='$penerbit',
        tahun='$tahun',
        stok='$stok',
        deskripsi='$deskripsi',
        cover='$cover'
        WHERE id_buku='$id'
    ");

    header("Location: buku.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Buku</title>
<link rel="stylesheet" href="buku.css">
</head>
<body>

<div class="container">
<h2>✏️ Edit Buku</h2>

<form method="post" enctype="multipart/form-data" class="card">
    <input name="judul" value="<?= $buku['judul']; ?>" required>
    <input name="penulis" value="<?= $buku['penulis']; ?>" required>
    <input name="penerbit" value="<?= $buku['penerbit']; ?>" required>
    <input type="number" name="tahun" value="<?= $buku['tahun']; ?>" required>
    <input type="number" name="stok" value="<?= $buku['stok']; ?>" required>
    <textarea name="deskripsi"><?= $buku['deskripsi']; ?></textarea>

    <label class="upload">
        📷 Ganti Cover
        <input type="file" name="cover">
    </label>

    <button name="update">💾 Simpan Perubahan</button>
</form>
</div>

</body>
</html>
