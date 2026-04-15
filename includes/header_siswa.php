<?php
// Memulai session untuk mengakses data login pengguna jika belum berjalan
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kantin Skomda</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <nav class="main-nav">
        <div class="nav-brand">
            <h1>KANTIN SKOMDA</h1>
        </div>
        <div class="nav-menu">
            <a href="index.php" class="nav-link">Home</a>
            <a href="keranjang.php" class="nav-link">Keranjang</a>
            <a href="logout.php" class="btn-logout">Logout</a>
        </div>
    </nav>