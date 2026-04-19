<?php

// memulai session untuk menyimpan data login pengguna
session_start();

// menghubungkan file ke database atau komponen lain
include 'config/koneksi.php';

// mengambil id keranjang dari parameter url
$id = $_GET['id'];

// menjalankan instruksi query ke database untuk menghapus item spesifik dari tabel keranjang
$query = mysqli_query($conn, "DELETE FROM keranjang WHERE id_keranjang = '$id'");

// validasi keberhasilan proses penghapusan data
if ($query) {

    // mengalihkan halaman ke lokasi yang ditentukan
    header("location:keranjang.php");
} else {

    // menampilkan notifikasi gagal dan mengalihkan halaman kembali ke keranjang
    echo "<script>alert('gagal menghapus item'); window.location='keranjang.php';</script>";
}
?>