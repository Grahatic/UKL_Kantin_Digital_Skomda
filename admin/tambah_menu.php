<?php
session_start();
include '../config/koneksi.php';

if (isset($_POST['simpan'])) {
    $nama   = $_POST['nama'];
    $harga  = $_POST['harga'];
    $gambar = $_FILES['foto']['name'];
    $tmp    = $_FILES['foto']['tmp_name'];

    // proses upload file gambar ke folder assets/img
    move_uploaded_file($tmp, "../assets/img/".$gambar);

    // simpan data ke database
    $query = mysqli_query($conn, "INSERT INTO menu (nama_menu, harga, gambar) VALUES ('$nama', '$harga', '$gambar')");

    if ($query) {
        echo "<script>alert('menu berhasil ditambah!'); window.location='dashboard.php';</script>";
    } else {
        echo "<script>alert('gagal tambah menu!');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Menu - Admin</title>
</head>
<body>
    <h2>Tambah Menu Baru</h2>
    <form method="POST" enctype="multipart/form-data">
        <label>Nama Menu</label><br>
        <input type="text" name="nama" required><br><br>

        <label>Harga</label><br>
        <input type="number" name="harga" required><br><br>

        <label>Gambar Menu</label><br>
        <input type="file" name="foto" required><br><br>

        <button type="submit" name="simpan">Simpan Menu</button>
        <a href="dashboard.php">kembali</a>
    </form>
</body>
</html>