<?php

// memulai session untuk mengakses data login pengguna
session_start();

// menghubungkan file ke database
include 'config/koneksi.php';

// menangkap ID user yang sedang login dari session
$id_user = $_SESSION['id_user'];

// mengambil tanggal hari ini untuk mencatat waktu transaksi
$tgl_transaksi = date("Y-m-d");

// menghitung total belanja di keranjang user saat ini dengan join tabel menu
$hitung = mysqli_query($conn, "SELECT SUM(menu.harga * keranjang.qty) as total 
                               FROM keranjang 
                               JOIN menu ON keranjang.id_menu = menu.id_menu 
                               WHERE keranjang.id_user = '$id_user'");

// memecah hasil perhitungan total menjadi array
$r = mysqli_fetch_assoc($hitung);

// menyimpan hasil total harga ke dalam variabel
$total_bayar = $r['total'];

// memasukkan data ke tabel transaksi utama
$insert_transaksi = mysqli_query($conn, "INSERT INTO transaksi (id_user, tgl_transaksi, total_bayar) 
                                         VALUES ('$id_user', '$tgl_transaksi', '$total_bayar')");

// mengecek apakah proses pembuatan transaksi utama berhasil
if ($insert_transaksi) {

    // mengambil ID transaksi oleh database
    $id_transaksi_baru = mysqli_insert_id($conn);

    // mengambil semua item dari keranjang untuk dipindahkan ke detail transaksi
    $isi_keranjang = mysqli_query($conn, "SELECT * FROM keranjang WHERE id_user = '$id_user'");

    // melakukan looping untuk memproses setiap item di keranjang
    while ($item = mysqli_fetch_array($isi_keranjang)) {

        // menangkap ID menu dari item keranjang
        $id_m = $item['id_menu'];

        // menangkap jumlah qty dari item keranjang
        $q   = $item['qty'];

        // mengambil harga menu terbaru untuk menghitung subtotal
        $get_menu = mysqli_query($conn, "SELECT harga FROM menu WHERE id_menu = '$id_m'");
        $m = mysqli_fetch_assoc($get_menu);

        // menghitung harga per item dikali jumlah beli
        $sub = $m['harga'] * $q;

        // memasukkan rincian item ke tabel detail transaksi
        mysqli_query($conn, "INSERT INTO detail_transaksi (id_transaksi, id_menu, qty, subtotal) 
                             VALUES ('$id_transaksi_baru', '$id_m', '$q', '$sub')");
    }

    // mengosongkan keranjang user karena seluruh item sudah berhasil dipesan
    mysqli_query($conn, "DELETE FROM keranjang WHERE id_user = '$id_user'");

    // memberikan feedback sukses dan mengarahkan user kembali ke halaman utama
    echo "<script>alert('pesanan berhasil dikonfirmasi!'); window.location='index.php';</script>";
} else {

    // memberikan feedback jika proses transaksi gagal dan kembali ke keranjang
    echo "<script>alert('gagal melakukan checkout'); window.location='keranjang.php';</script>";
}
