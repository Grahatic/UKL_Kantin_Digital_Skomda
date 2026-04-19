<?php
session_start();
include '../config/koneksi.php';

if ($_SESSION['role'] != "admin") {
    header("location:../login.php");
    exit;
}

$id_stand_admin = $_SESSION['id_stand'];
$id = mysqli_real_escape_string($conn, $_GET['id']);

$ambil_data = mysqli_query($conn, "SELECT * FROM menu WHERE id_menu='$id' AND id_stand='$id_stand_admin'");
$d = mysqli_fetch_array($ambil_data);

if (!$d) {
    echo "<script>alert('akses ditolak!'); window.location='dashboard.php';</script>";
    exit;
}

if (isset($_POST['update'])) {
    $nama   = mysqli_real_escape_string($conn, $_POST['nama']);
    $harga  = $_POST['harga'];
    $stok   = $_POST['stok']; // tangkap input stok
    $gambar = $_FILES['foto']['name'];
    $tmp    = $_FILES['foto']['tmp_name'];

    if ($gambar != "") {
        move_uploaded_file($tmp, "../assets/img/" . $gambar);
        // update termasuk kolom stok
        $query = "UPDATE menu SET nama_menu='$nama', harga='$harga', stok='$stok', gambar='$gambar' WHERE id_menu='$id' AND id_stand='$id_stand_admin'";
    } else {
        // update tanpa ganti gambar tapi stok tetep diupdate
        $query = "UPDATE menu SET nama_menu='$nama', harga='$harga', stok='$stok' WHERE id_menu='$id' AND id_stand='$id_stand_admin'";
    }

    $hasil = mysqli_query($conn, $query);

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
        <div class="nav-brand"><h1>SKOMDA KANTIN</h1></div>
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