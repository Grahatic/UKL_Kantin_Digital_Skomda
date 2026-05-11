<?php
include 'includes/header_siswa.php';
include 'config/koneksi.php';

// Proteksi ID
if (!isset($_GET['id'])) {
    echo "<script>window.location='index.php';</script>";
    exit;
}

$id_t = $_GET['id'];

// Query Presisi: Ambil total bayar, nama stand, dan foto qris
$query = "SELECT 
            t.total_bayar, 
            s.nama_stand, 
            s.foto_qris 
          FROM transaksi t
          JOIN detail_transaksi dt ON t.id_transaksi = dt.id_transaksi
          JOIN menu m ON dt.id_menu = m.id_menu
          JOIN stand s ON m.id_stand = s.id_stand
          WHERE t.id_transaksi = '$id_t' 
          LIMIT 1";

$sql = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($sql);

if (!$data) {
    die("Error: Data transaksi atau relasi stand tidak ditemukan.");
}
?>

<main style="padding: 40px 5%; display: flex; justify-content: center; background-color: #f4f4f4; min-height: 80vh;">
    <div style="background: white; padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); width: 100%; max-width: 400px; text-align: center; border: 1px solid #eee;">
        <h2 style="margin-bottom: 10px; color: #333;">Pembayaran QRIS</h2>
        <p style="color: #666; font-size: 0.9rem;">Silakan scan kode QR untuk Stand:<br><strong style="color: #ce1212;"><?php echo $data['nama_stand']; ?></strong></p>
        
        <div style="margin: 20px 0; padding: 15px; border: 2px dashed #ddd; border-radius: 15px; background: #fafafa;">
            <?php if(!empty($data['foto_qris'])): ?>
                <img src="assets/img/qris/<?php echo $data['foto_qris']; ?>" alt="QRIS Stand" style="width: 100%; border-radius: 10px; display: block;">
            <?php else: ?>
                <div style="padding: 40px 20px; color: #999; font-style: italic;">
                    ⚠️ Nama file gambar belum diisi di database (kolom foto_qris).
                </div>
            <?php endif; ?>
        </div>

        <div style="background: #fff5f5; padding: 15px; border-radius: 10px; margin-bottom: 25px; border: 1px solid #ffebeb;">
            <span style="display: block; font-size: 0.8rem; color: #666; margin-bottom: 5px;">Total Tagihan:</span>
            <strong style="font-size: 1.6rem; color: #ce1212;">Rp <?php echo number_format($data['total_bayar'], 0, ',', '.'); ?></strong>
        </div>

        <a href="riwayat.php" style="display: block; background: #ce1212; color: white; padding: 15px; border-radius: 10px; text-decoration: none; font-weight: bold; transition: 0.3s; box-shadow: 0 4px 15px rgba(206, 18, 18, 0.3);">
            SAYA SUDAH BAYAR
        </a>
        
        <p style="font-size: 0.75rem; color: #999; margin-top: 15px;">Klik tombol setelah lu selesai transfer/bayar via e-wallet.</p>
    </div>
</main>

<?php include 'includes/footer.php'; ?>