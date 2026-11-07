<?php
// =====================================================
//  login.php — Halaman masuk ke akun
// =====================================================

session_start();
include 'koneksi.php';

$error = '';
$flash = $_SESSION['flash'] ?? '';
unset($_SESSION['flash']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $user = trim($_POST['username'] ?? '');
    $pass = $_POST['password']      ?? '';

    if ($user === '' || $pass === '') {
        $error = 'Semua kolom wajib diisi.';
    } else {

        // Cari user berdasarkan username ATAU email
        $stmt = $koneksi->prepare("SELECT id, username, password FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $user, $user);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            // Verifikasi password yang di-hash
            if (password_verify($pass, $row['password'])) {

                // Buat sesi login
                $_SESSION['user_id']  = $row['id'];
                $_SESSION['username'] = $row['username'];

                header('Location: dashboard.php');
                exit;
            }
        }

        // Kalau sampai sini, berarti gagal
        $error = 'Username atau password salah.';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login — Web Dinamis</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="card">
        <h1>Masuk</h1>
        <p>Selamat datang kembali!</p>

        <?php if ($flash !== ''): ?>
            <div class="alert success"><?= htmlspecialchars($flash) ?></div>
        <?php endif; ?>

        <?php if ($error !== ''): ?>
            <div class="alert error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="username">Username / Email</label>
            <input type="text" id="username" name="username" required
                   placeholder="username atau email">

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required
                   placeholder="password kamu">

            <button type="submit">Masuk</button>
        </form>

        <p class="link">
            Belum punya akun? <a href="register.php">Daftar di sini</a>
        </p>
    </div>
</body>
</html>
