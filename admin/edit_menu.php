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

// membersihkan ID dari URL
$id = mysqli_real_escape_string($conn, $_GET['id']);

// mengambil data menu spesifik berdasarkan ID yang dikirim
$ambil_data = mysqli_query($conn, "SELECT * FROM menu WHERE id_menu='$id'");

// mmemecah hasil query menjadi array
$d = mysqli_fetch_array($ambil_data);

// cek apakah data ada jika tidak, kembalikan ke dashboard
if (!$d) {

    // memberikan pesan peringatan jika ID tidak ditemukan
    echo "<script>alert('Data tidak ditemukan!'); window.location='dashboard.php';</script>";

    // menghentikan proses
    exit;
}

// Mengecek apakah tombol 'update' sudah diklik
if (isset($_POST['update'])) {

    // mengamankan input teks
    $nama   = mysqli_real_escape_string($conn, $_POST['nama']);

    // menangkap input harga dari form
    $harga  = $_POST['harga'];

    // menangkap nama file gambar yang diunggah
    $gambar = $_FILES['foto']['name'];

    // menangkap lokasi sementara file gambar di server
    $tmp    = $_FILES['foto']['tmp_name'];

    // cek apakah admin mengunggah file gambar baru atau tidak
    if ($gambar != "") {

        // proses upload file gambar
        move_uploaded_file($tmp, "../assets/img/" . $gambar);

        // query update yang menyertakan nama file gambar baru
        $query = "UPDATE menu SET nama_menu='$nama', harga='$harga', gambar='$gambar' WHERE id_menu='$id'";
    } else {

        // query update tanpa mengganti gambar
        $query = "UPDATE menu SET nama_menu='$nama', harga='$harga' WHERE id_menu='$id'";
    }

    // menjalankan perintah update ke database
    $hasil = mysqli_query($conn, $query);

    // memberikan feedback sukses atau gagal kepada user
    if ($hasil) {

        // jika berhasil, munculkan alert dan pindah ke dashboard
        echo "<script>alert('Data menu berhasil diupdate!'); window.location='dashboard.php';</script>";
    } else {

        // jika gagal, munculkan alert error
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