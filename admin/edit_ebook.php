<?php
session_start();
include '../config.php';

$id = $_GET['id'];
$e = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM ebook WHERE id_ebook='$id'"));

if (isset($_POST['update'])) {
    $judul=$_POST['judul'];
    $penulis=$_POST['penulis'];
    $tahun=$_POST['tahun'];
    $deskripsi=$_POST['deskripsi'];

    $file = $e['file'];
    if (!empty($_FILES['file']['name'])) {
        if ($file) unlink("../assets/ebook/".$file);
        $file = uniqid().'_'.$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], "../assets/ebook/".$file);
    }

    $cover = $e['cover'];
    if (!empty($_FILES['cover']['name'])) {
        if ($cover) unlink("../assets/ebook/cover/".$cover);
        $cover = uniqid().'_'.$_FILES['cover']['name'];
        move_uploaded_file($_FILES['cover']['tmp_name'], "../assets/ebook/cover/".$cover);
    }

    mysqli_query($conn,"
        UPDATE ebook SET
        judul='$judul', penulis='$penulis',
        tahun='$tahun', deskripsi='$deskripsi',
        file='$file', cover='$cover'
        WHERE id_ebook='$id'
    ");

    header("Location: ebook.php");
}
?>
