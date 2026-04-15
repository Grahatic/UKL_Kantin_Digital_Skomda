<?php

// Memulai session untuk mengakses data login pengguna
session_start();

// Menghubungkan file ke database agar bisa manipulasi data
include '../config/koneksi.php';

// Mengecek apakah user yang masuk memiliki hak akses sebagai admin
if ($_SESSION['role'] != "admin") {
    
    // Jika bukan admin, arahkan kembali ke halaman login
    header("location:../login.php");
    
    // Menghentikan seluruh eksekusi script agar kode di bawahnya tidak berjalan
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Kantin Skomda</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    
    <nav class="main-nav">
    <div class="nav-brand">
        <h1>SKOMDA KANTIN</h1>
    </div>
    <div class="nav-menu">
        <a href="dashboard.php" class="nav-link">Kelola Menu</a>
        <span class="admin-name">Admin: <strong><?php echo $_SESSION['username']; ?></strong></span>
        <a href="../logout.php" class="btn-logout">Logout</a>
    </div>
</nav>

    <div class="admin-container">
        
        <div class="admin-header">
            <h2>Daftar Menu Kantin</h2>
            <a href="tambah_menu.php" class="btn-tambah">+ tambah menu baru</a>
        </div>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Nama Menu</th>
                    <th>Harga</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Ambil data dari database (Gunakan variabel koneksi lu: $conn)
                $ambildata = mysqli_query($conn, "SELECT * FROM menu");
                $no = 1;
                while($data = mysqli_fetch_array($ambildata)){
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td>
                        <img src="../assets/img/<?php echo $data['gambar']; ?>" alt="gambar menu">
                    </td>
                    <td><?php echo $data['nama_menu']; ?></td>
                    <td>Rp <?php echo number_format($data['harga'], 0, ',', '.'); ?></td>
                    <td>
                        <a href="edit_menu.php?id=<?php echo $data['id_menu']; ?>" class="link-edit">Edit</a>
                        <a href="hapus_menu.php?id=<?php echo $data['id_menu']; ?>" class="link-hapus" onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</body>
</html>