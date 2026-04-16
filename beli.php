<?php

// memulai session untukk mengakses data login pengguna
session_start();

// panggil koneksi database
include 'config/koneksi.php';

// ambil id_menu dari tombol pesan di index.php
$id_menu = $_GET['id'];

// ambil id_user dari session login
$id_user = $_SESSION['id_user'];

// set jumlah beli default adalah 1
$qty = 1;

// masukkan data ke tabel keranjang
$query = "INSERT INTO keranjang (id_user, id_menu, qty) VALUES ('$id_user', '$id_menu', '$qty')";
$hasil = mysqli_query($conn, $query);

// cek apakah proses berhasil
if ($hasil) {

    // jika berhasil, lempar user ke halaman keranjang
    echo "<script>alert('berhasil ditambah ke keranjang'); window.location='keranjang.php';</script>";
} else {

    // jika gagal, kasih peringatan dan balik ke index
    echo "<script>alert('gagal menambah pesanan'); window.location='index.php';</script>";
}
