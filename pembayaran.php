<?php
include 'includes/header_siswa.php';
include 'config/koneksi.php';

if (!isset($_GET['id'])) {
    echo "<script>window.location='index.php';</script>";
    exit;
}

$id_t = $_GET['id'];

// Query Audit: Kita ambil data transaksi dan hubungkan ke stand melalui detail_transaksi
$query = "SELECT 
            t.id_transaksi, 
            t.total_bayar, 
            s.nama_stand 
          FROM transaksi t
          JOIN detail_transaksi dt ON t.id_transaksi = dt.id_transaksi
          JOIN menu m ON dt.id_menu = m.id_menu
          JOIN stand s ON m.id_stand = s.id_stand
          WHERE t.id_transaksi = '$id_t'
          LIMIT 1";

$sql = mysqli_query($conn, $query);

// Jika query JOIN di atas gagal (mungkin karena data stand belum relasi), 
// kita pakai Plan B: Ambil data transaksi murni saja.
if (mysqli_num_rows($sql) == 0) {
    $sql_simple = mysqli_query($conn, "SELECT * FROM transaksi WHERE id_transaksi = '$id_t'");
    $data = mysqli_fetch_assoc($sql_simple);
    $nama_stand = "Kantin Skomda"; // Default jika join gagal
} else {
    $data = mysqli_fetch_assoc($sql);
    $nama_stand = $data['nama_stand'];
}

if (!$data) {
    die("Data transaksi tidak ditemukan.");
}

// Pastikan variabel nominal mengambil dari kolom yang benar sesuai screenshot lu
$nominal = $data['total_bayar'];
?>

<main style="padding: 40px 5%; display: flex; justify-content: center;">
    <div style="background: white; padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); width: 100%; max-width: 450px; text-align: center; border: 1px solid #eee;">
        <h2 style="color: #333;">Finalisasi Pembayaran</h2>
        <p style="color: #666;">No. Pesanan: <strong>#<?php echo $id_t; ?></strong></p>

        <div style="background: #fff5f5; padding: 20px; border-radius: 15px; margin: 20px 0; border: 1px dashed #ce1212;">
            <p style="margin:0; font-size: 0.9rem; color: #666;">Total Tagihan:</p>
            <h1 style="margin: 5px 0; color: #ce1212;">Rp <?php echo number_format($nominal, 0, ',', '.'); ?></h1>
            <p style="margin:0; font-weight: bold;">Stand: <?php echo $nama_stand; ?></p>
        </div>

        <div style="display: grid; gap: 15px;">
            <a href="update_metode.php?id=<?php echo $id_t; ?>&metode=qris" 
               style="background: #ce1212; color: white; padding: 15px; border-radius: 10px; text-decoration: none; font-weight: bold; display: flex; align-items: center; justify-content: center; gap: 10px;">
               <span>📱</span> BAYAR PAKAI QRIS
            </a>

            <a href="update_metode.php?id=<?php echo $id_t; ?>&metode=cash" 
               style="background: white; color: #ce1212; padding: 15px; border-radius: 10px; text-decoration: none; font-weight: bold; border: 2px solid #ce1212; display: flex; align-items: center; justify-content: center; gap: 10px;">
               <span>💵</span> BAYAR TUNAI DI KASIR
            </a>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>