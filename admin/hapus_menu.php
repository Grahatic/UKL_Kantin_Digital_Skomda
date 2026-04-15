<?php

// Memulai session untuk mengakses data login pengguna
session_start();

// Menghubungkan file ke database agar bisa manipulasi data
include '../config/koneksi.php';

// Proteksi: kalau bukan admin, tendang ke login
if ($_SESSION['role'] != "admin") {

    // Arahkan paksa kembali ke halaman login
    header("location:../login.php");

    // Menghentikan seluruh eksekusi script agar kode di bawahnya tidak berjalan
    exit;
}

// Membersihkan ID dari URL untuk mencegah serangan SQL Injection
$id = mysqli_real_escape_string($conn, $_GET['id']);

// Menjalankan query untuk menghapus data menu berdasarkan ID
$query = mysqli_query($conn, "DELETE FROM menu WHERE id_menu='$id'");

// Memberikan feedback sukses atau gagal kepada user
if ($query) {

    // Jika berhasil, munculkan alert dan pindah ke dashboard
    echo "<script>alert('Menu berhasil dihapus!'); window.location='dashboard.php';</script>";
} else {
    
    // Jika gagal, munculkan alert error dan kembali ke dashboard
    echo "<script>alert('Gagal hapus menu!'); window.location='dashboard.php';</script>";
}
?>