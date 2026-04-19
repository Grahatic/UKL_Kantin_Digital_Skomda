<?php
session_start();
include '../config/koneksi.php';

if ($_SESSION['role'] != "admin") {
    header("location:../login.php");
    exit;
}

// ambil identitas menu dan admin
$id_stand_admin = $_SESSION['id_stand'];
$id = mysqli_real_escape_string($conn, $_GET['id']);

// eksekusi hapus tapi hanya jika id_menu DAN id_stand cocok
$query = mysqli_query($conn, "DELETE FROM menu WHERE id_menu='$id' AND id_stand='$id_stand_admin'");

// cek apakah ada baris yang terhapus
if (mysqli_affected_rows($conn) > 0) {
    echo "<script>alert('menu berhasil dihapus!'); window.location='dashboard.php';</script>";
} else {
    // kalau id nggak cocok atau bukan miliknya
    echo "<script>alert('gagal hapus!); window.location='dashboard.php';</script>";
}
?>