<?php
session_start();
include '../config/koneksi.php';

// proteksi: kalau bukan admin, tendang ke login
if ($_SESSION['role'] != "admin") {
    header("location:../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - Kantin Skomda</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <nav>
        <h1>DASHBOARD - ADMIN</h1>
        <ul>
            <li><a href="dashboard.php">kelola menu</a></li>
            <li><a href="../logout.php">logout</a></li>
        </ul>
        <span>Admin: <?php echo $_SESSION['username']; ?></span>
    </nav>

    <section style="padding: 40px 5%;">
        <h2>Daftar Menu Kantin</h2>
        <br>
        <a href="tambah_menu.php" style="background: green; color: white; padding: 10px; text-decoration: none; border-radius: 5px;">+ tambah menu baru</a>
        <br><br>

        <table border="1" cellpadding="10" cellspacing="0" width="100%">
            <thead>
                <tr style="background: #f4f4f4;">
                    <th>no</th>
                    <th>gambar</th>
                    <th>nama menu</th>
                    <th>harga</th>
                    <th>opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $query = mysqli_query($conn, "SELECT * FROM menu");
                while ($d = mysqli_fetch_array($query)) {
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><img src="../assets/img/<?php echo $d['gambar']; ?>" width="50"></td>
                        <td><?php echo $d['nama_menu']; ?></td>
                        <td>Rp <?php echo number_format($d['harga']); ?></td>
                        <td>
                            <a href="edit_menu.php?id=<?php echo $d['id_menu']; ?>">edit</a> | 
                            <a href="hapus_menu.php?id=<?php echo $d['id_menu']; ?>" onclick="return confirm('yakin mau hapus?')">hapus</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </section>
</body>
</html>