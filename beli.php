<?php
session_start();
include 'config/koneksi.php';

// Ambil ID Menu
$id_menu = mysqli_real_escape_string($conn, $_GET['id']);
$id_user = $_SESSION['id_user'];
$qty = 1;

// --- STEP 1: CEK STOK DI DATABASE (LOGIKA VALIDASI) ---
$cek_stok = mysqli_query($conn, "SELECT stok FROM menu WHERE id_menu = '$id_menu'");
$s = mysqli_fetch_array($cek_stok);

if ($s['stok'] <= 0) {
    // JIKA STOK HABIS: Usir user dengan alert tegas
    echo "<script>alert('MAAF! Stok baru saja habis. Anda tidak bisa memesan menu ini.'); window.location='index.php';</script>";
    exit; // Berhenti di sini, jangan lanjut ke query INSERT
}

// --- STEP 2: LANJUT INSERT JIKA STOK TERSEDIA ---
$query = "INSERT INTO keranjang (id_user, id_menu, qty) VALUES ('$id_user', '$id_menu', '$qty')";
$hasil = mysqli_query($conn, $query);

if ($hasil) {
    echo "<script>alert('Berhasil ditambah ke keranjang!'); window.location='keranjang.php';</script>";
} else {
    echo "<script>alert('Gagal menambah pesanan'); window.location='index.php';</script>";
}
?>