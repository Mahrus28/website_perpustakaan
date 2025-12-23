<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login Perpustakaan</title>
<link rel="stylesheet" href="login.css">
</head>
<body>

<div class="auth-box">

    <h2 id="formTitle">Login Perpustakaan</h2>

    <!-- TAB -->
    <div class="tabs">
        <button id="btnLogin" class="active">Sign In</button>
        <button id="btnRegister">Sign Up</button>
    </div>

    <!-- ALERT -->
    <?php if(isset($_GET['error'])): ?>
        <div class="alert error">Username atau password salah</div>
    <?php endif; ?>

    <?php if(isset($_GET['signup'])): ?>
        <div class="alert success">Registrasi berhasil, silakan login</div>
    <?php endif; ?>

    <!-- <?php if (isset($_GET['error'])): ?>
    <div class="alert error" id="loginError">
    ❌ Username atau password salah!
    </div>
    <?php endif; ?> -->

    <!-- LOGIN FORM -->
    <form id="loginForm" method="post" action="login_proses.php">
        <input name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button>Sign In</button>
    </form>

    <!-- REGISTER FORM (USER ONLY) -->
    <form id="registerForm" method="post" action="register_user.php" class="hidden">
        <input name="nama" placeholder="Nama Lengkap" required>
        <input name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button>Sign Up</button>
        <p class="note">* Pendaftaran hanya untuk USER</p>
    </form>

</div>

<script>
const btnLogin = document.getElementById("btnLogin");
const btnRegister = document.getElementById("btnRegister");
const loginForm = document.getElementById("loginForm");
const registerForm = document.getElementById("registerForm");
const title = document.getElementById("formTitle");

btnLogin.onclick = () => {
    btnLogin.classList.add("active");
    btnRegister.classList.remove("active");
    loginForm.classList.remove("hidden");
    registerForm.classList.add("hidden");
    title.innerText = "Login Perpustakaan";
};

btnRegister.onclick = () => {
    btnRegister.classList.add("active");
    btnLogin.classList.remove("active");
    registerForm.classList.remove("hidden");
    loginForm.classList.add("hidden");
    title.innerText = "Registrasi User";
};
</script>

</body>
</html>
