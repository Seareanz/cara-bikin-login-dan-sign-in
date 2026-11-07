<?php
// =====================================================
//  dashboard.php — Halaman utama setelah login
//  HANYA bisa diakses oleh user yang sudah login.
// =====================================================

session_start();

// Proteksi: kalau belum login, tendang ke halaman login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard — Web Dinamis</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="card">
        <h1>Halo, <?= htmlspecialchars($_SESSION['username']) ?>! 👋</h1>
        <p>Kamu berhasil masuk. Ini halaman dashboard yang hanya bisa diakses oleh pengguna yang sudah login.</p>

        <div class="info">
            <p><strong>ID:</strong> <?= (int) $_SESSION['user_id'] ?></p>
            <p><strong>Username:</strong> <?= htmlspecialchars($_SESSION['username']) ?></p>
            <p><strong>Login pada:</strong> <?= date('d-m-Y H:i:s') ?></p>
        </div>

        <a class="btn btn-danger" href="logout.php">Keluar (Logout)</a>
    </div>
</body>
</html>
