<?php
include '../config.php';

if(isset($_GET['kembali'])){
 $tgl=date('Y-m-d');
 $p=mysqli_fetch_assoc(mysqli_query($conn,
 "SELECT * FROM peminjaman WHERE id_peminjaman=$_GET[kembali]"));

 $denda=0;
 if($tgl>$p['tanggal_kembali']){
  $denda=5000;
 }

 mysqli_query($conn,
 "UPDATE peminjaman SET status='dikembalikan', denda=$denda 
  WHERE id_peminjaman=$_GET[kembali]");
}
