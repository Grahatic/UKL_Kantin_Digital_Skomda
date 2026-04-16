<?php

// memulai session untuk mengakses data login pengguna
session_start();

// menghubungkan file ke database
include '../config/koneksi.php';

// proteksi
if ($_SESSION['role'] != "admin") {

    // arahkan paksa kembali ke halaman login
    header("location:../login.php");

    // menghentikan proses
    exit;
}

// mengecek apakah tombol 'simpan' sudah diklik
if (isset($_POST['simpan'])) {

    // mengamankan input teks
    $nama   = mysqli_real_escape_string($conn, $_POST['nama']);

    // menangkap input harga dari form
    $harga  = $_POST['harga'];

    // menangkap nama file gambar yang diunggah
    $gambar = $_FILES['foto']['name'];

    // menangkap lokasi sementara file gambar di server
    $tmp    = $_FILES['foto']['tmp_name'];

    // proses upload file gambar ke folder assets/img
    if (move_uploaded_file($tmp, "../assets/img/" . $gambar)) {

        // menjalankan query untuk menyimpan data menu baru ke database
        $query = mysqli_query($conn, "INSERT INTO menu (nama_menu, harga, gambar) VALUES ('$nama', '$harga', '$gambar')");

        // memberikan feedback
        if ($query) {

            // jika berhasil, munculkan alert dan pindah ke dashboard
            echo "<script>alert('Menu berhasil ditambah!'); window.location='dashboard.php';</script>";
        } else {

            // jika gagal simpan ke database, munculkan alert error
            echo "<script>alert('Gagal simpan ke database!');</script>";
        }
    } else {

        // jika gagal upload file ke folder, munculkan alert error
        echo "<script>alert('Gagal upload gambar!');</script>";
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
                <h2>Tambah Menu Baru</h2>
                <p>Gunakan gambar rasio 1:1 untuk hasil terbaik di katalog siswa.</p>
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
                    <label>Foto Menu</label>
                    <input type="file" name="foto" required>
                </div>

                <div class="form-actions">
                    <button type="submit" name="simpan" class="btn-simpan">Simpan Menu</button>
                    <a href="dashboard.php" class="btn-kembali">Kembali</a>
                </div>
            </form>
        </div>
    </div>

</body>

</html>