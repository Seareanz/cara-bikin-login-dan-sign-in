<?php
// =====================================================
//  register.php — Halaman pendaftaran akun baru
//  Berisi: logika PHP (atas) + tampilan HTML (bawah)
// =====================================================

session_start();
include 'koneksi.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. Ambil data dari form, lalu bersihkan
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email']    ?? '');
    $password = $_POST['password']      ?? '';

    // 2. Validasi
    if ($username === '' || $email === '' || $password === '') {
        $error = 'Semua kolom wajib diisi.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Format email tidak valid.';
    } elseif (strlen($password) < 6) {
        $error = 'Password minimal 6 karakter.';
    } else {

        // 3. Cek apakah username/email sudah dipakai
        $stmt = $koneksi->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = 'Username atau email sudah terdaftar.';

        } else {
            // 4. Hash password (JANGAN simpan plaintext!)
            $hash = password_hash($password, PASSWORD_DEFAULT);

            // 5. Simpan ke database
            $stmt = $koneksi->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hash);

            if ($stmt->execute()) {
                $_SESSION['flash'] = 'Registrasi berhasil! Silakan login.';
                header('Location: login.php');
                exit;
            }

            $error = 'Terjadi kesalahan. Coba lagi.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register — Web Dinamis</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="card">
        <h1>Buat Akun Baru</h1>
        <p>Daftar dulu sebelum masuk ke dashboard.</p>

        <?php if ($error !== ''): ?>
            <div class="alert error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="username">Username</label>
            <input type="text" id="username" name="username"
                   minlength="3" maxlength="50" required
                   placeholder="contoh: zean">

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required
                   placeholder="nama@email.com">

            <label for="password">Password</label>
            <input type="password" id="password" name="password"
                   minlength="6" required
                   placeholder="minimal 6 karakter">

            <button type="submit">Daftar</button>
        </form>

        <p class="link">
            Sudah punya akun? <a href="login.php">Login di sini</a>
        </p>
    </div>
</body>
</html>
