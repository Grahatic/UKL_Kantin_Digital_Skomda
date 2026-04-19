<?php
// memulai session untuk mengakses data login pengguna
session_start();

// menghubungkan file ke database
include '../config/koneksi.php';

// proteksi: pastikan hanya admin yang bisa akses
if ($_SESSION['role'] != "admin") {
    header("location:../login.php");
    exit;
}

// mengecek apakah tombol 'simpan' sudah diklik
if (isset($_POST['simpan'])) {

    // mengamankan input teks
    $nama   = mysqli_real_escape_string($conn, $_POST['nama']);
    $harga  = $_POST['harga'];
    
    // menangkap input stok baru
    $stok   = $_POST['stok'];

    // ambil id_stand otomatis dari session admin yang login
    $id_stand = $_SESSION['id_stand'];

    // menangkap data gambar
    $gambar = $_FILES['foto']['name'];
    $tmp    = $_FILES['foto']['tmp_name'];

    // proses upload file gambar ke folder assets/img
    if (move_uploaded_file($tmp, "../assets/img/" . $gambar)) {

        // masukkan id_stand DAN stok ke dalam query insert
        $query = mysqli_query($conn, "INSERT INTO menu (nama_menu, harga, stok, gambar, id_stand) 
                                      VALUES ('$nama', '$harga', '$stok', '$gambar', '$id_stand')");

        if ($query) {
            echo "<script>alert('menu berhasil ditambah dengan stok!'); window.location='dashboard.php';</script>";
        } else {
            echo "<script>alert('gagal simpan ke database!');</script>";
        }
    } else {
        echo "<script>alert('gagal upload gambar!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Menu Baru - Admin Skomda</title>
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
        <div class="form-card">
            <div class="form-header">
                <h2>Tambah Menu Baru (Opsi Stok Aktif)</h2>
                <p>Input jumlah porsi yang tersedia hari ini.</p>
            </div>

            <form method="POST" enctype="multipart/form-data">
                <div class="input-group">
                    <label>Nama Menu</label>
                    <input type="text" name="nama" placeholder="Misal: Bakso Aci Spesial" required>
                </div>

                <div class="input-group">
                    <label>Harga (Rp)</label>
                    <input type="number" name="harga" placeholder="Contoh: 15000" required>
                </div>

                <div class="input-group">
                    <label>Stok Awal (Porsi)</label>
                    <input type="number" name="stok" placeholder="Contoh: 20" min="0" required>
                </div>

                <div class="input-group">
                    <label>Foto Menu</label>
                    <input type="file" name="foto" required>
                </div>

                <div class="form-actions">
                    <button type="submit" name="simpan" class="btn-simpan">Simpan Menu & Stok</button>
                    <a href="dashboard.php" class="btn-kembali">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>