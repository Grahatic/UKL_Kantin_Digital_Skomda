<?php

// memulai session untuk menyimpan data login pengguna
session_start();

// menghubungkan file ke database atau komponen lain
include '../config/koneksi.php';

// memeriksa hak akses pengguna apakah sebagai admin
if ($_SESSION['role'] != "admin") {

    // mengalihkan halaman ke lokasi yang ditentukan
    header("location:../login.php");

    // menghentikan eksekusi script
    exit;
}

// mengambil id stand milik admin dari data session
$id_stand_admin = $_SESSION['id_stand'];

// mengambil id menu dari parameter url dan mengamankan input dari sql injection
$id = mysqli_real_escape_string($conn, $_GET['id']);

// menjalankan instruksi query ke database untuk menghapus data berdasarkan id menu dan id stand
$query = mysqli_query($conn, "DELETE FROM menu WHERE id_menu='$id' AND id_stand='$id_stand_admin'");

// validasi apakah ada baris data yang berhasil terhapus di database
if (mysqli_affected_rows($conn) > 0) {
    echo "<script>alert('menu berhasil dihapus!'); window.location='dashboard.php';</script>";
} else {

    // validasi jika proses hapus gagal karena id tidak ditemukan atau kendala hak akses
    echo "<script>alert('gagal hapus!'); window.location='dashboard.php';</script>";
}
