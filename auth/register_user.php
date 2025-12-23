<?php
require '../config.php';

$nama = $_POST['nama'];
$username = $_POST['username'];
$password = md5($_POST['password']);

mysqli_query($conn,
"INSERT INTO users (nama,username,password,role)
 VALUES ('$nama','$username','$password','user')");

header("Location: login.php?signup=1");
