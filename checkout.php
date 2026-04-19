<?php
// memulai session untuk mengakses data login pengguna
session_start();

// menghubungkan file ke database
include 'config/koneksi.php';

// proteksi: pastikan hanya siswa yang bisa checkout
if ($_SESSION['role'] != "siswa") {
    header("location:login.php");
    exit;
}

$id_user = $_SESSION['id_user'];
$tgl_transaksi = date("Y-m-d");

// 1. Ambil data keranjang dan hitung total sekaligus (JOIN tabel menu untuk ambil harga)
$query_keranjang = "SELECT keranjang.*, menu.harga, menu.stok 
                    FROM keranjang 
                    JOIN menu ON keranjang.id_menu = menu.id_menu 
                    WHERE keranjang.id_user = '$id_user'";
$isi_keranjang = mysqli_query($conn, $query_keranjang);

// Jika keranjang kosong, jangan lanjut
if (mysqli_num_rows($isi_keranjang) == 0) {
    echo "<script>alert('Keranjang belanja anda kosong!'); window.location='index.php';</script>";
    exit;
}

// 2. Hitung Total Bayar
$total_bayar = 0;
while ($row = mysqli_fetch_assoc(mysqli_query($conn, $query_keranjang))) {
    $total_bayar += ($row['harga'] * $row['qty']);
}

// 3. Masukkan ke tabel Transaksi Utama
$insert_transaksi = mysqli_query($conn, "INSERT INTO transaksi (id_user, tgl_transaksi, total_bayar) 
                                         VALUES ('$id_user', '$tgl_transaksi', '$total_bayar')");

if ($insert_transaksi) {
    $id_transaksi_baru = mysqli_insert_id($conn);

    // Ambil ulang data keranjang untuk di-looping ke Detail Transaksi dan Potong Stok
    $proses_item = mysqli_query($conn, $query_keranjang);

    while ($item = mysqli_fetch_array($proses_item)) {
        $id_m = $item['id_menu'];
        $q   = $item['qty'];
        $sub = $item['harga'] * $q;

        // A. Masukkan ke Tabel Detail Transaksi
        mysqli_query($conn, "INSERT INTO detail_transaksi (id_transaksi, id_menu, qty, subtotal) 
                             VALUES ('$id_transaksi_baru', '$id_m', '$q', '$sub')");

        // B. LOGIKA POTONG STOK (INTI PERUBAHAN)
        // Mengurangi stok di tabel menu berdasarkan jumlah yang dibeli
        mysqli_query($conn, "UPDATE menu SET stok = stok - $q WHERE id_menu = '$id_m'");
    }

    // 4. Kosongkan keranjang user setelah semua proses selesai
    mysqli_query($conn, "DELETE FROM keranjang WHERE id_user = '$id_user'");

    echo "<script>alert('PESANAN BERHASIL! Stok kantin otomatis terupdate.'); window.location='index.php';</script>";
} else {
    echo "<script>alert('Gagal melakukan checkout, cek koneksi database!'); window.location='keranjang.php';</script>";
}
?>