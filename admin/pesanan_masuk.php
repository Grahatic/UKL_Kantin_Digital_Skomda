<?php
// memulai session untuk menyimpan data login pengguna
session_start();

// menghubungkan file ke database atau komponen lain
include '../config/koneksi.php';

// memeriksa hak akses pengguna apakah sebagai admin
if ($_SESSION['role'] != "admin") {
    header("location:../login.php");
    exit;
}

$id_s = $_SESSION['id_stand'];
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Masuk - Kantin Skomda</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        /* CSS INTERNAL UNTUK PESANAN MASUK */
        body { background-color: #f4f4f4; }
        
        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-pending { background-color: #ffe5e5; color: #d9534f; border: 1px solid #d9534f; }
        .status-selesai { background-color: #e5f9e5; color: #28a745; border: 1px solid #28a745; }
        
        .btn-selesai {
            background-color: #28a745;
            color: white;
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 13px;
            transition: 0.3s;
        }
        .btn-selesai:hover { background-color: #218838; }
        
        .kembali-link {
            display: inline-block;
            margin-bottom: 15px;
            color: #ce1212;
            text-decoration: none;
            font-weight: bold;
        }
        
        .admin-table th { background-color: #ce1212; color: white; }
        .no-data { text-align: center; padding: 20px; color: #888; }
    </style>
</head>

<body>

    <nav class="main-nav">
        <div class="nav-brand">
            <h1>PESANAN MASUK - STAND <?php echo $id_s; ?></h1>
        </div>
        <div class="nav-menu">
            <a href="dashboard.php" class="nav-link">Kelola Menu</a>
            <a href="pesanan_masuk.php" class="nav-link active" style="background-color: #ce1212; padding: 5px 10px; border-radius: 4px;"> Pesanan Masuk</a>
            <a href="laporan.php" class="nav-link">Laporan</a>
            <span class="admin-name">Admin: <strong><?php echo $_SESSION['username']; ?></strong></span>
            <a href="../logout.php" class="btn-logout">Logout</a>
        </div>
    </nav>

    <div class="admin-container">
        <div class="admin-header">
            <a href="dashboard.php" class="kembali-link">← Kembali ke Dashboard</a>
            <h2>Daftar Antrean Pesanan</h2>
        </div>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>No. Transaksi</th>
                    <th>Tanggal</th>
                    <th>Nama Pelanggan</th>
                    <th>Total Bayar</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // query JOIN untuk ambil data transaksi
                $query = "SELECT DISTINCT t.*, u.username 
                          FROM transaksi t
                          JOIN user u ON t.id_user = u.id_user
                          JOIN detail_transaksi dt ON t.id_transaksi = dt.id_transaksi
                          JOIN menu m ON dt.id_menu = m.id_menu
                          WHERE m.id_stand = '$id_s'
                          ORDER BY t.id_transaksi DESC";

                $sql = mysqli_query($conn, $query);

                if (mysqli_num_rows($sql) == 0) {
                    echo "<tr><td colspan='6' class='no-data'>Belum ada pesanan yang masuk.</td></tr>";
                }

                while ($d = mysqli_fetch_array($sql)) {
                ?>
                <tr>
                    <td><strong>#<?php echo $d['id_transaksi']; ?></strong></td>
                    <td><?php echo date('d M Y', strtotime($d['tgl_transaksi'])); ?></td>
                    <td><?php echo $d['username']; ?></td>
                    <td>Rp <?php echo number_format($d['total_bayar'], 0, ',', '.'); ?></td>
                    <td>
                        <?php if ($d['status'] == 'Pending') : ?>
                            <span class="status-badge status-pending">Menunggu</span>
                        <?php else : ?>
                            <span class="status-badge status-selesai">Selesai</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($d['status'] == 'Pending') : ?>
                            <a href="update_status.php?id=<?php echo $d['id_transaksi']; ?>" 
                               class="btn-selesai" 
                               onclick="return confirm('Yakin pesanan ini sudah selesai?')">
                               Selesaikan
                            </a>
                        <?php else : ?>
                            <span style="color: #bbb;">Sudah Diproses</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</body>
</html>