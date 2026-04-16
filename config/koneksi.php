<?php

// variabel alamat server database
$host = "localhost";

// variabel nama user database
$user = "root";

// variabel kata sandi database
$pass = "";

// variabel nama database
$db   = "db_ukl_kantin";

// fungsi menghubungkan php ke server mysql
$conn = mysqli_connect($host, $user, $pass, $db);

// cek status keberhasilan koneksi ke database
if (!$conn) {

    // menghentikan sistem dan menampilkan pesan error koneksi
    die("koneksi database gagal: " . mysqli_connect_error());
}
