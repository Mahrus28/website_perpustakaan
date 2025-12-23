<?php
include '../config.php';
if($_SESSION['role']!='superadmin'){ exit; }
$data=mysqli_query($conn,"SELECT * FROM users");
?>
<h2>Dashboard Super Admin</h2>
<?php while($u=mysqli_fetch_assoc($data)){ ?>
<p><?= $u['nama']; ?> - <?= $u['role']; ?></p>
<?php } ?>
