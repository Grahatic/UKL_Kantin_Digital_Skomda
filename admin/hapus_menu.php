<?php

// memulai session untuk mengakses data login pengguna
session_start();

// menghubungkan file ke database
include '../config/koneksi.php';

// proteksi
if ($_SESSION['role'] != "admin") {

    // arahkan paksa kembali ke halaman login
    header("location:../login.php");

    // menghentikan proses
    exit;
}

// membersihkan ID dari URL
$id = mysqli_real_escape_string($conn, $_GET['id']);

// menjalankan query untuk menghapus data menu berdasarkan ID
$query = mysqli_query($conn, "DELETE FROM menu WHERE id_menu='$id'");

// memberikan feedback kepada user
if ($query) {

    // jika berhasil, munculkan alert dan pindah ke dashboard
    echo "<script>alert('Menu berhasil dihapus!'); window.location='dashboard.php';</script>";
} else {

    // jika gagal, munculkan alert error dan kembali ke dashboard
    echo "<script>alert('Gagal hapus menu!'); window.location='dashboard.php';</script>";
}
