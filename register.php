<?php
// Menghubungkan file kodingan dengan database di folder config
include "config/koneksi.php"; 

if (isset($_POST['register'])) {
    $nama     = $_POST['nama'];
    $username = $_POST['username'];
    $password = md5($_POST['password']); 
    $email    = $_POST['email'];
    $level    = 'siswa'; 

    $sql = mysqli_query($koneksi, "INSERT INTO user (nama, username, password, email, level) 
           VALUES ('$nama', '$username', '$password', '$email', '$level')");

    if ($sql) {
        echo "<script>alert('Registrasi Berhasil! Silakan Login.'); location.href='login.php';</script>";
    } else {
        echo "<script>alert('Registrasi Gagal!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Kantin Pre-Order Skomda</title>
    <style>
        /* Menyamakan background dengan halaman login lu */
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #212529; /* Dark theme sesuai login */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* Container putih di tengah */
        .register-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        /* Styling Logo (Gue asumsikan path logonya sama) */
        .logo {
            width: 120px;
            margin-bottom: 10px;
        }

        h2 {
            color: #333;
            margin-bottom: 25px;
            font-size: 24px;
        }

        /* Styling Input agar identik dengan login lu */
        input {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
            box-sizing: border-box;
            font-size: 14px;
        }

        /* Tombol Merah Skomda */
        button {
            width: 100%;
            background-color: #dc3545; /* Merah sesuai login lu */
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            margin-top: 15px;
            font-size: 16px;
            transition: 0.3s;
        }

        button:hover {
            background-color: #c82333;
        }

        p {
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }

        a {
            color: #dc3545;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="register-container">
    <img src="assets/img/logo 1.svg" alt="Logo Skomda" class="logo">
    <h2>Kantin Register</h2>
    
    <form method="POST">
        <input type="text" name="nama" placeholder="Nama Lengkap" required>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="email" name="email" placeholder="Email" required>
        <button type="submit" name="register">Register</button>
    </form>
    
    <p>Sudah punya akun? <a href="login.php">Login</a></p>
</div>

</body>
</html>