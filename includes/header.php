<?php

// Memulai session untuk mengakses data login pengguna jika belum berjalan
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Proteksi: kalau belum login, tendang balik ke halaman login
if (!isset($_SESSION['status'])) {

    // Arahkan paksa kembali ke halaman login
    header("location:login.php");
    
    // Menghentikan seluruh eksekusi script agar kode di bawahnya tidak berjalan
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kantin Skomda</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <nav style="background-color: #d9534f; padding: 15px 5%; display: flex; justify-content: space-between; align-items: center; color: white;">
    <h1 style="margin: 0; font-size: 1.5rem;">DASHBOARD ADMIN</h1>
    <div>
        <a href="dashboard.php" style="color: white; text-decoration: none; margin-right: 20px;">Kelola Menu</a>
        <a href="../logout.php" style="color: white; text-decoration: none; border: 1px solid white; padding: 5px 15px; border-radius: 5px;">Logout</a>
    </div>
    </nav>
    <hr>