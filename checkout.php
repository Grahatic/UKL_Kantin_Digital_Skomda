<?php
session_start();
include 'config/koneksi.php';

$id_user = $_SESSION['id_user'];
$tgl_transaksi = date("Y-m-d");

// 1. hitung total belanja di keranjang user saat ini
$hitung = mysqli_query($conn, "SELECT SUM(menu.harga * keranjang.qty) as total 
                               FROM keranjang 
                               JOIN menu ON keranjang.id_menu = menu.id_menu 
                               WHERE keranjang.id_user = '$id_user'");
$r = mysqli_fetch_assoc($hitung);
$total_bayar = $r['total'];

// 2. masukkan data ke tabel transaksi utama
$insert_transaksi = mysqli_query($conn, "INSERT INTO transaksi (id_user, tgl_transaksi, total_bayar) 
                                         VALUES ('$id_user', '$tgl_transaksi', '$total_bayar')");

if ($insert_transaksi) {
    // ambil id_transaksi yang baru saja dibuat
    $id_transaksi_baru = mysqli_insert_id($conn);

    // 3. pindahkan semua item dari keranjang ke detail_transaksi
    $isi_keranjang = mysqli_query($conn, "SELECT * FROM keranjang WHERE id_user = '$id_user'");
    while ($item = mysqli_fetch_array($isi_keranjang)) {
        $id_m = $item['id_menu'];
        $q   = $item['qty'];
        
        // ambil harga menu untuk subtotal
        $get_menu = mysqli_query($conn, "SELECT harga FROM menu WHERE id_menu = '$id_m'");
        $m = mysqli_fetch_assoc($get_menu);
        $sub = $m['harga'] * $q;

        mysqli_query($conn, "INSERT INTO detail_transaksi (id_transaksi, id_menu, qty, subtotal) 
                             VALUES ('$id_transaksi_baru', '$id_m', '$q', '$sub')");
    }

    // 4. kosongkan keranjang user karena transaksi sudah selesai
    mysqli_query($conn, "DELETE FROM keranjang WHERE id_user = '$id_user'");

    echo "<script>alert('pesanan berhasil dikonfirmasi! silahkan tunggu makanan anda'); window.location='index.php';</script>";
} else {
    echo "<script>alert('gagal melakukan checkout'); window.location='keranjang.php';</script>";
}
?>