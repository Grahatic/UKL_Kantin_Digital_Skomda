<?php

// Memulai session untuk mengakses data login pengguna
session_start();

// Menghubungkan file ke database agar bisa manipulasi data
include 'config/koneksi.php';

// Menangkap ID user yang sedang login dari session
$id_user = $_SESSION['id_user'];

// Mengambil tanggal hari ini untuk mencatat waktu transaksi
$tgl_transaksi = date("Y-m-d");

// Menghitung total belanja di keranjang user saat ini dengan join tabel menu
$hitung = mysqli_query($conn, "SELECT SUM(menu.harga * keranjang.qty) as total 
                               FROM keranjang 
                               JOIN menu ON keranjang.id_menu = menu.id_menu 
                               WHERE keranjang.id_user = '$id_user'");

// Memecah hasil perhitungan total menjadi array
$r = mysqli_fetch_assoc($hitung);

// Menyimpan hasil total harga ke dalam variabel
$total_bayar = $r['total'];

// Memasukkan data ke tabel transaksi utama sebagai record induk
$insert_transaksi = mysqli_query($conn, "INSERT INTO transaksi (id_user, tgl_transaksi, total_bayar) 
                                         VALUES ('$id_user', '$tgl_transaksi', '$total_bayar')");

// Mengecek apakah proses pembuatan transaksi utama berhasil
if ($insert_transaksi) {

    // Mengambil ID transaksi yang baru saja dibuat secara otomatis oleh database
    $id_transaksi_baru = mysqli_insert_id($conn);

    // Mengambil semua item dari keranjang untuk dipindahkan ke detail transaksi
    $isi_keranjang = mysqli_query($conn, "SELECT * FROM keranjang WHERE id_user = '$id_user'");
    
    // Melakukan perulangan untuk memproses setiap item di keranjang
    while ($item = mysqli_fetch_array($isi_keranjang)) {

        // Menangkap ID menu dari item keranjang
        $id_m = $item['id_menu'];

        // Menangkap jumlah (qty) dari item keranjang
        $q   = $item['qty'];
        
        // Mengambil harga menu terbaru untuk menghitung subtotal
        $get_menu = mysqli_query($conn, "SELECT harga FROM menu WHERE id_menu = '$id_m'");
        $m = mysqli_fetch_assoc($get_menu);
        
        // Menghitung harga per item dikali jumlah beli
        $sub = $m['harga'] * $q;

        // Memasukkan rincian item ke tabel detail transaksi
        mysqli_query($conn, "INSERT INTO detail_transaksi (id_transaksi, id_menu, qty, subtotal) 
                             VALUES ('$id_transaksi_baru', '$id_m', '$q', '$sub')");
    }

    // Mengosongkan keranjang user karena seluruh item sudah berhasil dipesan
    mysqli_query($conn, "DELETE FROM keranjang WHERE id_user = '$id_user'");

    // Memberikan feedback sukses dan mengarahkan user kembali ke halaman utama
    echo "<script>alert('pesanan berhasil dikonfirmasi!'); window.location='index.php';</script>";
} else {

    // Memberikan feedback jika proses transaksi gagal dan kembali ke keranjang
    echo "<script>alert('gagal melakukan checkout'); window.location='keranjang.php';</script>";
}
?>