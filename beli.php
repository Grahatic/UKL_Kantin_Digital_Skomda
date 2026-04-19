<?php

// memulai session untuk menyimpan data login pengguna
session_start();

// menghubungkan file ke database atau komponen lain
include 'config/koneksi.php';

// mengambil id menu dari parameter url dan mengamankan input dari sql injection
$id_menu = mysqli_real_escape_string($conn, $_GET['id']);

// mengambil id user dari data session yang aktif
$id_user = $_SESSION['id_user'];

// menjalankan instruksi query ke database untuk memeriksa ketersediaan stok menu
$cek_stok = mysqli_query($conn, "SELECT stok FROM menu WHERE id_menu = '$id_menu'");

// mengambil data dari hasil query menjadi array
$s = mysqli_fetch_array($cek_stok);

// validasi jika data menu tidak ditemukan atau stok bernilai nol
if (!$s || $s['stok'] <= 0) {
    echo "<script>alert('MAAF! Stok habis.'); window.location='index.php';</script>";

    // menghentikan eksekusi script
    exit;
}

// menjalankan instruksi query ke database untuk memeriksa apakah menu sudah ada di keranjang user
$cek_keranjang = mysqli_query($conn, "SELECT * FROM keranjang WHERE id_user = '$id_user' AND id_menu = '$id_menu'");

// mengambil data dari hasil query menjadi array
$sudah_ada = mysqli_fetch_array($cek_keranjang);

// memeriksa hasil pencarian data di keranjang
if ($sudah_ada) {
    
    // menyusun instruksi query untuk memperbarui jumlah kuantitas jika data sudah tersedia
    $query = "UPDATE keranjang SET qty = qty + 1 WHERE id_user = '$id_user' AND id_menu = '$id_menu'";
} else {

    // menyusun instruksi query untuk memasukkan data baru ke tabel keranjang
    $query = "INSERT INTO keranjang (id_user, id_menu, qty) VALUES ('$id_user', '$id_menu', 1)";
}

// menjalankan instruksi query ke database
$hasil = mysqli_query($conn, $query);

// validasi keberhasilan proses manipulasi data keranjang
if ($hasil) {

    // mengalihkan halaman ke lokasi yang ditentukan
    echo "<script>alert('Berhasil masuk keranjang!'); window.location='keranjang.php';</script>";
} else {
    
    // mengalihkan halaman kembali jika terjadi kegagalan sistem
    echo "<script>alert('Gagal sistem!'); window.location='index.php';</script>";
}
?>