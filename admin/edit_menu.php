<?php
session_start();
include '../config/koneksi.php';

// ambil id menu yang mau diedit dari URL
$id = $_GET['id'];
$ambil_data = mysqli_query($conn, "SELECT * FROM menu WHERE id_menu='$id'");
$d = mysqli_fetch_array($ambil_data);

if (isset($_POST['update'])) {
    $nama   = $_POST['nama'];
    $harga  = $_POST['harga'];
    $gambar = $_FILES['foto']['name'];
    $tmp    = $_FILES['foto']['tmp_name'];

    // jika admin mengganti gambar
    if ($gambar != "") {
        move_uploaded_file($tmp, "../assets/img/".$gambar);
        $query = "UPDATE menu SET nama_menu='$nama', harga='$harga', gambar='$gambar' WHERE id_menu='$id'";
    } else {
        // jika admin tidak mengganti gambar (pakai gambar lama)
        $query = "UPDATE menu SET nama_menu='$nama', harga='$harga' WHERE id_menu='$id'";
    }

    $hasil = mysqli_query($conn, $query);

    if ($hasil) {
        echo "<script>alert('data menu berhasil diupdate!'); window.location='dashboard.php';</script>";
    } else {
        echo "<script>alert('gagal update menu!');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Menu - Admin</title>
</head>
<body>
    <h2>Edit Menu</h2>
    <form method="POST" enctype="multipart/form-data">
        <label>Nama Menu</label><br>
        <input type="text" name="nama" value="<?php echo $d['nama_menu']; ?>" required><br><br>

        <label>Harga</label><br>
        <input type="number" name="harga" value="<?php echo $d['harga']; ?>" required><br><br>

        <label>Gambar (Kosongkan jika tidak ingin ganti gambar)</label><br>
        <img src="../assets/img/<?php echo $d['gambar']; ?>" width="100"><br>
        <input type="file" name="foto"><br><br>

        <button type="submit" name="update">Simpan Perubahan</button>
        <a href="dashboard.php">batal</a>
    </form>
</body>
</html>