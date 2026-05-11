<?php
session_start();
include 'config/koneksi.php';

$id_t = $_GET['id'];
$metode = $_GET['metode']; // Isinya 'cash' atau 'qris'

// Update database (Gue pake nama kolom 'metode_pembayaran' sesuai yang sudah lu benerin tadi)
$query = "UPDATE transaksi SET metode_pembayaran = '$metode' WHERE id_transaksi = '$id_t'";

if (mysqli_query($conn, $query)) {
    if ($metode == 'qris') {
        // Jika QRIS, lempar ke halaman yang nampilin gambar QRIS
        header("location:tampil_qris.php?id=$id_t");
    } else {
        // Jika Cash, kasih alert dan balik ke riwayat
        echo "<script>
                alert('Pesanan dicatat! Silakan lakukan pembayaran TUNAI di kasir stand.');
                window.location='riwayat.php';
              </script>";
    }
} else {
    echo "Gagal update metode: " . mysqli_error($conn);
}
?>