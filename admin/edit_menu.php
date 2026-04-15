<?php
// Memulai session untuk mengakses data login pengguna
session_start();

// Menghubungkan file ke database agar bisa manipulasi data
include '../config/koneksi.php';

// Proteksi: kalau bukan admin, tendang ke login
if ($_SESSION['role'] != "admin") {
    // Arahkan paksa kembali ke halaman login
    header("location:../login.php");
    // Menghentikan seluruh eksekusi script agar kode di bawahnya tidak berjalan
    exit;
}

// Membersihkan ID dari URL untuk mencegah serangan SQL Injection
$id = mysqli_real_escape_string($conn, $_GET['id']);

// Mengambil data menu spesifik berdasarkan ID yang dikirim
$ambil_data = mysqli_query($conn, "SELECT * FROM menu WHERE id_menu='$id'");

// Memecah hasil query menjadi array agar bisa ditampilkan di form
$d = mysqli_fetch_array($ambil_data);

// Cek apakah data ada; jika tidak, kembalikan ke dashboard
if (!$d) {
    // Memberikan pesan peringatan jika ID tidak ditemukan
    echo "<script>alert('Data tidak ditemukan!'); window.location='dashboard.php';</script>";
    // Menghentikan proses karena data tidak valid
    exit;
}

// Mengecek apakah tombol 'update' sudah diklik oleh admin
if (isset($_POST['update'])) {
    // Mengamankan input teks dari karakter berbahaya
    $nama   = mysqli_real_escape_string($conn, $_POST['nama']);
    // Menangkap input harga dari form
    $harga  = $_POST['harga'];
    
    // Menangkap nama file gambar yang diunggah
    $gambar = $_FILES['foto']['name'];
    // Menangkap lokasi sementara file gambar di server
    $tmp    = $_FILES['foto']['tmp_name'];

    // Logika: Cek apakah admin mengunggah file gambar baru atau tidak
    if ($gambar != "") {
        // Proses upload file gambar ke folder assets/img
        move_uploaded_file($tmp, "../assets/img/".$gambar);
        // Query update yang menyertakan nama file gambar baru
        $query = "UPDATE menu SET nama_menu='$nama', harga='$harga', gambar='$gambar' WHERE id_menu='$id'";
    } else {
        // Query update tanpa mengganti gambar (pakai gambar lama)
        $query = "UPDATE menu SET nama_menu='$nama', harga='$harga' WHERE id_menu='$id'";
    }

    // Menjalankan perintah update ke database
    $hasil = mysqli_query($conn, $query);

    // Memberikan feedback sukses atau gagal kepada user
    if ($hasil) {
        // Jika berhasil, munculkan alert dan pindah ke dashboard
        echo "<script>alert('Data menu berhasil diupdate!'); window.location='dashboard.php';</script>";
    } else {
        // Jika gagal, munculkan alert error
        echo "<script>alert('Gagal update menu!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Menu - Admin Skomda</title>
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
                <h2>Edit Menu</h2>
                <p>Ubah detail menu sesuai kebutuhan stok atau harga baru.</p>
            </div>
            
            <form method="POST" enctype="multipart/form-data">
                <div class="input-group">
                    <label>Nama Menu</label>
                    <input type="text" name="nama" value="<?php echo $d['nama_menu']; ?>" required>
                </div>

                <div class="input-group">
                    <label>Harga (Rp)</label>
                    <input type="number" name="harga" value="<?php echo $d['harga']; ?>" required>
                </div>

                <div class="input-group">
                    <label>Gambar Saat Ini</label>
                    <img src="../assets/img/<?php echo $d['gambar']; ?>" width="150" height="110" class="img-preview">
                    <small style="color: #777;">Kosongkan di bawah ini jika tidak ingin mengganti gambar.</small>
                    <input type="file" name="foto" style="margin-top: 10px;">
                </div>

                <div class="form-actions">
                    <button type="submit" name="update" class="btn-simpan">Simpan Perubahan</button>
                    <a href="dashboard.php" class="btn-kembali">Batal</a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>