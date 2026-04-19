<?php

// memulai session untuk menyimpan data login pengguna
session_start();

// menghubungkan file ke database atau komponen lain
include '../config/koneksi.php';

// memeriksa hak akses pengguna apakah sebagai admin
if ($_SESSION['role'] != "admin") {

    // mengalihkan halaman ke lokasi yang ditentukan
    header("location:../login.php");

    // menghentikan eksekusi script
    exit;
}

// mengambil id stand milik admin dari data session
$id_stand_admin = $_SESSION['id_stand'];

// mengambil id menu dari parameter url dan mengamankan input dari sql injection
$id = mysqli_real_escape_string($conn, $_GET['id']);

// menjalankan instruksi query ke database untuk mengambil data menu berdasarkan id dan id stand
$ambil_data = mysqli_query($conn, "SELECT * FROM menu WHERE id_menu='$id' AND id_stand='$id_stand_admin'");

// mengambil data dari hasil query menjadi array
$d = mysqli_fetch_array($ambil_data);

// validasi jika data tidak ditemukan atau admin mencoba mengakses menu stand lain
if (!$d) {
    echo "<script>alert('akses ditolak!'); window.location='dashboard.php';</script>";

    // menghentikan eksekusi script
    exit;
}

// memeriksa apakah form tombol update telah ditekan
if (isset($_POST['update'])) {

    // mengamankan input teks nama menu dari sql injection
    $nama   = mysqli_real_escape_string($conn, $_POST['nama']);

    // mengambil input harga dari form
    $harga  = $_POST['harga'];

    // mengambil input stok dari form
    $stok   = $_POST['stok'];

    // mengambil nama file gambar yang diunggah
    $gambar = $_FILES['foto']['name'];

    // mengambil lokasi sementara file yang diunggah
    $tmp    = $_FILES['foto']['tmp_name'];

    // validasi jika pengguna mengunggah gambar baru
    if ($gambar != "") {

        // memindahkan file gambar dari lokasi sementara ke direktori tujuan
        move_uploaded_file($tmp, "../assets/img/" . $gambar);

        // menyusun instruksi query update data menu termasuk file gambar baru
        $query = "UPDATE menu SET nama_menu='$nama', harga='$harga', stok='$stok', gambar='$gambar' WHERE id_menu='$id' AND id_stand='$id_stand_admin'";
    } else {

        // menyusun instruksi query update data menu tanpa mengubah gambar
        $query = "UPDATE menu SET nama_menu='$nama', harga='$harga', stok='$stok' WHERE id_menu='$id' AND id_stand='$id_stand_admin'";
    }

    // menjalankan instruksi query ke database
    $hasil = mysqli_query($conn, $query);

    // validasi keberhasilan proses pembaruan data
    if ($hasil) {
        echo "<script>alert('data menu & stok berhasil diupdate!'); window.location='dashboard.php';</script>";
    } else {
        echo "<script>alert('gagal update menu!');</script>";
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
            <a href="../logout.php" class="btn-logout">Logout</a>
        </div>
    </nav>

    <div class="admin-container">
        <div class="form-card">
            <div class="form-header">
                <h2>Edit Menu & Kelola Stok</h2>
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
                    <label>Stok Tersedia (Porsi)</label>
                    <input type="number" name="stok" value="<?php echo $d['stok']; ?>" min="0" required>
                </div>

                <div class="input-group">
                    <label>Gambar Saat Ini</label>
                    <img src="../assets/img/<?php echo $d['gambar']; ?>" width="150" class="img-preview">
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