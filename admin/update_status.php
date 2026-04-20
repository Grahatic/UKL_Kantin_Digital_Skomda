<?php
session_start();
include '../config/koneksi.php';

// mengammbil id dari url
$id = $_GET['id'];

if (isset($id)) {
    // jalankan update status
    $query = "UPDATE transaksi SET status = 'Selesai' WHERE id_transaksi = '$id'";
    $update = mysqli_query($conn, $query);

    if ($update) {

        // balik ke halaman daftar pesanan
        header("location:pesanan_masuk.php");
    } else {
        echo "Gagal mengupdate status: " . mysqli_error($conn);
    }
} else {
    header("location:pesanan_masuk.php");
}
?>