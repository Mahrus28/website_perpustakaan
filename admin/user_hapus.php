<?php
session_start();
include '../config.php';

if($_SESSION['role']!='admin'){
    exit;
}

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM users WHERE id_user='$id'");

header("Location: user.php");
exit;
