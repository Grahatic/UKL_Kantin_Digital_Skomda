<?php

// menghubungkan file kodingan dengan database
include "config/koneksi.php";

if (isset($_POST['register'])) {

    // mengambil data dan mencegah karakter aneh masuk ke database
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']);
    $role     = 'siswa';

    // cek dulu apakah username sudah pernah dipakai orang lain
    $cek_user = mysqli_query($conn, "SELECT * FROM user WHERE username='$username'");
    
    if (mysqli_num_rows($cek_user) > 0) {
        
        // jika username sudah ada di database
        echo "<script>alert('username sudah ada, cari yang lain!');</script>";
    } else {

        // jika username aman, langsung masukkan ke database
        $sql = mysqli_query($conn, "INSERT INTO user (username, password, role) 
               VALUES ('$username', '$password', '$role')");

        if ($sql) {

            // jika berhasil, tendang ke halaman login
            echo "<script>alert('registrasi berhasil! silakan login.'); location.href='login.php';</script>";
        } else {

            // jika gagal karena sistem error
            echo "<script>alert('registrasi gagal!');</script>";
        }
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
        
        /* styling dasar buat halaman register */
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #212529;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* kotak putih di tengah */
        .register-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .logo {
            width: 120px;
            margin-bottom: 10px;
        }

        h2 {
            color: #333;
            margin-bottom: 25px;
            font-size: 24px;
        }

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

        button {
            width: 100%;
            background-color: #ce1212; /* merah sesuai tema skomda lu */
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
            background-color: #a00e0e;
        }

        p {
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }

        a {
            color: #ce1212;
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
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="register">Register</button>
        </form>

        <p>Sudah punya akun? <a href="login.php">Login</a></p>
    </div>

</body>

</html>