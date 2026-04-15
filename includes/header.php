<?php
// cek apakah session sudah jalan, kalo belum kita jalankan
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// proteksi halaman, kalo belum login suruh balik ke login.php
if (!isset($_SESSION['status'])) {
    header("location:login.php");
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
    <nav>
        <h1>SKOMDA KANTIN</h1>
        <ul>
            <li><a href="index.php">home</a></li>
            <li><a href="keranjang.php">keranjang</a></li>
            <li><a href="logout.php">logout</a></li>
        </ul>
        <span>Hi, <?php echo $_SESSION['username']; ?>!</span>
    </nav>
    <hr>