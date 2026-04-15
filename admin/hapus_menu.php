<?php
session_start();
include '../config/koneksi.php';

// ambil id menu dari link
$id = $_GET['id'];

// jalankan query hapus data
$query = mysqli_query($conn, "DELETE FROM menu WHERE id_menu='$id'");

if ($query) {
    echo "<script>alert('menu berhasil dihapus!'); window.location='dashboard.php';</script>";
} else {
    echo "<script>alert('gagal hapus menu!'); window.location='dashboard.php';</script>";
}
?>