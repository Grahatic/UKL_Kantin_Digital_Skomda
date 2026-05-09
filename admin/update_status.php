<?php
session_start();
include '../config/koneksi.php';

if (!isset($conn) && isset($koneksi)) {
    $conn = $koneksi;
}

if (!isset($conn)) {
    die('Database connection not available.');
}

// mengammbil id 
$id = isset($_GET['id']) ? $_GET['id'] : null;

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
