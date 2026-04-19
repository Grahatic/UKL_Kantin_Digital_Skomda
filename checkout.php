<?php

// memulai session untuk menyimpan data login pengguna
session_start();

// menghubungkan file ke database atau komponen lain
include 'config/koneksi.php';

// memeriksa hak akses pengguna apakah sebagai siswa
if ($_SESSION['role'] != "siswa") {

    // mengalihkan halaman ke lokasi yang ditentukan
    header("location:login.php");

    // menghentikan eksekusi script
    exit;
}

// mengambil id user dari data session yang aktif
$id_user = $_SESSION['id_user'];

// mengambil tanggal hari ini untuk pencatatan transaksi
$tgl_transaksi = date("Y-m-d");

// menyusun instruksi query untuk mengambil data keranjang dan detail menu menggunakan join
$query_keranjang = "SELECT keranjang.*, menu.harga, menu.stok 
                    FROM keranjang 
                    JOIN menu ON keranjang.id_menu = menu.id_menu 
                    WHERE keranjang.id_user = '$id_user'";

// menjalankan instruksi query ke database
$isi_keranjang = mysqli_query($conn, $query_keranjang);

// validasi jika keranjang belanja kosong sebelum memproses transaksi
if (mysqli_num_rows($isi_keranjang) == 0) {
    echo "<script>alert('Keranjang belanja anda kosong!'); window.location='index.php';</script>";

    // menghentikan eksekusi script
    exit;
}

// inisialisasi variabel total pembayaran dan penampung data keranjang
$total_bayar = 0;
$keranjang_items = [];

// mengambil data dari hasil query menjadi array
while ($row = mysqli_fetch_assoc($isi_keranjang)) {

    // akumulasi total bayar berdasarkan harga dan kuantitas
    $total_bayar += ($row['harga'] * $row['qty']);

    // memasukkan data baris ke dalam array sementara
    $keranjang_items[] = $row; 
}

// menjalankan instruksi query ke database untuk memasukkan data ke tabel transaksi utama
$insert_transaksi = mysqli_query($conn, "INSERT INTO transaksi (id_user, tgl_transaksi, total_bayar) 
                                         VALUES ('$id_user', '$tgl_transaksi', '$total_bayar')");

// validasi keberhasilan pembuatan data transaksi utama
if ($insert_transaksi) {
    
    // mendapatkan id transaksi terbaru yang baru saja dimasukkan
    $id_transaksi_baru = mysqli_insert_id($conn);

    // melakukan perulangan data dari array sementara untuk proses detail
    foreach ($keranjang_items as $item) {
        $id_m = $item['id_menu'];
        $q   = $item['qty'];
        $sub = $item['harga'] * $q;

        // menjalankan instruksi query ke database untuk memasukkan detail transaksi
        mysqli_query($conn, "INSERT INTO detail_transaksi (id_transaksi, id_menu, qty, subtotal) 
                             VALUES ('$id_transaksi_baru', '$id_m', '$q', '$sub')");

        // menjalankan instruksi query ke database untuk mengurangi stok di tabel menu
        mysqli_query($conn, "UPDATE menu SET stok = stok - $q WHERE id_menu = '$id_m'");
    }

    // menjalankan instruksi query ke database untuk mengosongkan keranjang user
    mysqli_query($conn, "DELETE FROM keranjang WHERE id_user = '$id_user'");

    // menampilkan notifikasi sukses dan mengalihkan halaman ke riwayat
    echo "<script>alert('PESANAN BERHASIL!'); window.location='riwayat.php';</script>";
} else {
    
    // menampilkan notifikasi gagal jika transaksi utama gagal disimpan
    echo "<script>alert('Gagal melakukan checkout!'); window.location='keranjang.php';</script>";
}
?>