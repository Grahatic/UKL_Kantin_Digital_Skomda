<?php
// mulai session buat simpen data login user
session_start(); 

// panggil file koneksi buat akses database
include 'config/koneksi.php'; 

// cek apakah tombol login sudah ditekan
if (isset($_POST['masuk'])) { 

    // ambil data dari inputan form
    $username = $_POST['user']; 
    $password = $_POST['pass']; 

    // cari data user di database yang cocok dengan inputan
    $query = "SELECT * FROM user WHERE username='$username' AND password='$password'";
    $hasil = mysqli_query($conn, $query); 
    $cek   = mysqli_num_rows($hasil); 

    // jika data user ditemukan
    if ($cek > 0) { 
        $data = mysqli_fetch_assoc($hasil); 

        // simpan identitas penting user ke dalam session
        $_SESSION['id_user']  = $data['id_user']; 
        $_SESSION['username'] = $data['username']; 
        $_SESSION['role']     = $data['role']; 
        $_SESSION['status']   = "login"; 

        // arahkan user sesuai dengan level atau role nya
        if ($data['role'] == "admin") { 
            echo "<script>alert('selamat datang admin!'); window.location='admin/dashboard.php';</script>";
        } else { 
            echo "<script>alert('selamat datang siswa!'); window.location='index.php';</script>";
        }
    } else { 
        // kasih peringatan kalau username atau password salah
        echo "<script>alert('login gagal! periksa kembali akun anda');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Kantin Skomda</title>
</head>
<body>
    <h2>Login Kantin</h2>
    <form method="POST"> 
        <label>Username</label><br>
        <input type="text" name="user" required><br><br>
        
        <label>Password</label><br>
        <input type="password" name="pass" required><br><br>
        
        <button type="submit" name="masuk">Login Sekarang</button>
    </form>
</body>
</html>