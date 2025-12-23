<?php
session_start();
require '../config.php';

$username = $_POST['username'];
$password = md5($_POST['password']);

$query = mysqli_query($conn,
    "SELECT * FROM users 
     WHERE username='$username' AND password='$password'"
);

$user = mysqli_fetch_assoc($query);

if ($user) {
    $_SESSION['login'] = true;
    $_SESSION['role']  = $user['role'];
    $_SESSION['nama']  = $user['nama'];

    if ($user['role'] === 'superadmin') {
        header("Location: ../superadmin/dashboard.php");
    } elseif ($user['role'] === 'admin') {
        header("Location: ../admin/dashboard.php");
    } else {
        header("Location: ../user/dashboard.php");
    }
    exit;
} else {
    // LOGIN GAGAL
    header("Location: login.php?error=1");
    exit;
}
