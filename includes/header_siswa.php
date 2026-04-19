<?php

// memulai session untuk menyimpan data login pengguna
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// memeriksa status login pengguna untuk proteksi halaman
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {

    // mengalihkan halaman ke lokasi yang ditentukan
    header("location:login.php");

    // menghentikan eksekusi script
    exit;
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
    <nav class="main-nav" style="
        background: white; 
        padding: 15px 5%; 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        border-bottom: 3px solid #ddd;
        margin-bottom: 5px;
    ">
        <div class="nav-left">
            <span style="color: #333; font-size: 1rem;">Hi,
                <strong style="color: #ce1212;">
                    <?php echo $_SESSION['username']; ?>
                </strong>!
            </span>
        </div>

        <div class="nav-right" style="display: flex; align-items: center; gap: 20px;">
            <a href="index.php" style="text-decoration: none; color: #333; font-weight: bold; font-size: 0.9rem;">Beranda</a>
            <a href="riwayat.php" style="text-decoration: none; color: #333; font-weight: bold; font-size: 0.9rem;">Riwayat</a>

            <a href="keranjang.php" style="text-decoration: none; font-size: 1.2rem;">🛒</a>

            <a href="logout.php" style="
                background: #ce1212; 
                color: white; 
                padding: 7px 15px; 
                border-radius: 8px; 
                text-decoration: none; 
                font-weight: bold; 
                font-size: 0.8rem;
            ">Logout</a>
        </div>
    </nav>