<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "perpustakaan"; // HARUS SAMA PERSIS

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi DB gagal: " . mysqli_connect_error());
}