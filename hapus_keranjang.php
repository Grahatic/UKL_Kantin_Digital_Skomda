<?php
// memulai session untuk memastikan akses user
session_start();

// menghubungkan ke file database
include 'config/koneksi.php';

// menangkap id keranjang yang dikirim melalui url
$id = $_GET['id'];

// melakukan query untuk menghapus item spesifik dari tabel keranjang
$query = mysqli_query($conn, "DELETE FROM keranjang WHERE id_keranjang = '$id'");

// mengecek keberhasilan proses hapus
if ($query) {
    // jika berhasil, kembalikan ke halaman keranjang
    header("location:keranjang.php");
} else {
    // jika gagal, tampilkan pesan error
    echo "<script>alert('gagal menghapus item'); window.location='keranjang.php';</script>";
}
?>