<?php
include '../config.php';
$b=mysqli_fetch_assoc(mysqli_query($conn,
"SELECT * FROM buku WHERE id_buku=$_GET[id]"));
?>
<h2><?= $b['judul']; ?></h2>
<p><?= $b['deskripsi']; ?></p>
<p>Stok: <?= $b['stok']; ?></p>
