<?php

// memulai session untuk memastikan akses user
session_start();

// menghubungkan file ke database atau komponen lain
include 'config/koneksi.php';

// memastikan parameter id dan aksi tersedia di dalam url
if (isset($_GET['id']) && isset($_GET['aksi'])) {

    // mengamankan input id keranjang dari ancaman sql injection
    $id_keranjang = mysqli_real_escape_string($conn, $_GET['id']);

    // mengambil jenis aksi (tambah atau kurang)
    $aksi = $_GET['aksi'];

    // menjalankan instruksi query untuk mengambil jumlah kuantitas dan stok menu menggunakan join
    $query = "SELECT keranjang.qty, menu.stok 
              FROM keranjang 
              JOIN menu ON keranjang.id_menu = menu.id_menu 
              WHERE keranjang.id_keranjang = '$id_keranjang'";

    // menjalankan instruksi query ke database
    $hasil = mysqli_query($conn, $query);

    // mengambil data hasil query menjadi array
    $data = mysqli_fetch_array($hasil);

    // logika penambahan jumlah pesanan
    if ($aksi == 'tambah') {

        // validasi apakah jumlah kuantitas saat ini masih lebih kecil dari stok yang tersedia
        if ($data['qty'] < $data['stok']) {

            // memperbarui data kuantitas di tabel keranjang dengan penambahan satu satuan
            mysqli_query($conn, "UPDATE keranjang SET qty = qty + 1 WHERE id_keranjang = '$id_keranjang'");
        } else {

            // menampilkan notifikasi jika batas maksimal stok tercapai
            echo "<script>alert('Maaf, stok sudah habis atau mencapai batas maksimal!'); window.location='keranjang.php';</script>";

            // menghentikan eksekusi script
            exit;
        }
    }
    // logika pengurangan jumlah pesanan
    elseif ($aksi == 'kurang') {

        // memastikan jumlah kuantitas minimal bernilai satu sebelum dikurangi
        if ($data['qty'] > 1) {

            // memperbarui data kuantitas di tabel keranjang dengan pengurangan satu satuan
            mysqli_query($conn, "UPDATE keranjang SET qty = qty - 1 WHERE id_keranjang = '$id_keranjang'");
        }
    }

    // mengalihkan halaman kembali ke tampilan keranjang belanja
    header("location:keranjang.php");
} else {

    // mengalihkan ke halaman utama jika akses parameter tidak valid
    header("location:index.php");
}
