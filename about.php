<?php include 'includes/header.php'; ?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>About Developer - Kantin Digital</title>
    <style>
        /* reset margin dan padding default browser */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        /* memberikan warna background abu-abu muda pada seluruh halaman */
        body {
            background-color: #f4f4f4;
            color: #333;
        }

        /* container utama untuk memusatkan konten profile */
        .about-wrapper {
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
        }

        /* styling kartu profil dengan efek bayangan dan background putih */
        .profile-card {
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding-bottom: 30px;
        }

        /* background header padacard profil */
        .card-header {
            background: #800000;
            height: 120px;
            width: 100%;
        }

        /* styling foto profil berbentuk lingkaran dengan border putih */
        .profile-img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 5px solid #fff;
            margin-top: -75px;
            object-fit: cover;
            background: #fff;
        }

        /* styling untuk nama lengkap developer */
        .profile-card h1 {
            margin-top: 15px;
            font-size: 24px;
            color: #333;
        }

        /* styling untuk kelas dan peran developer */
        .profile-card p.sub {
            color: #800000;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* container untuk deskripsi singkat diri */
        .bio {
            padding: 20px 50px;
            line-height: 1.6;
            color: #666;
            font-size: 15px;
        }

        /* section untuk menampilkan deretan skill teknologi */
        .tech-stack {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 15px;
        }

        /* badge kecil untuk tiap item teknologi */
        .tech-badge {
            background: #eee;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            color: #555;
        }

        /* garis pembatas horizontal */
        hr {
            border: 0;
            height: 1px;
            background: #eee;
            margin: 30px 50px;
        }

        /* section informasi tambahan tentang project */
        .project-info {
            padding: 0 50px;
            text-align: left;
        }

        /* judul kecil untuk section info project */
        .project-info h3 {
            font-size: 18px;
            margin-bottom: 10px;
            color: #333;
            border-left: 4px solid #800000;
            padding-left: 10px;
        }

        /* tombol logout/kembali sesuai referensi desain user */
        .btn-back {
            display: inline-block;
            margin-top: 30px;
            padding: 10px 30px;
            background: #333;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.3s;
        }

        /* efek hover pada tombol */
        .btn-back:hover {
            background: #800000;
        }
    </style>
</head>

<body>

    <main class="about-wrapper">
        <div class="profile-card">
            <div class="card-header"></div>

            <img src="assets/img/foto_sae.jpeg" alt="Foto Yosua Ade" class="profile-img">

            <h1>Yosua Ade Nugraha</h1>
            <p class="sub">X-SIJA-1 | Full Stack Developer</p>

            <div class="bio">
                "Berfokus pada pengembangan sistem informasi yang efisien untuk mendukung digitalisasi sekolah melalui solusi automasi."
            </div>

            <div class="tech-stack">
                <span class="tech-badge">HTML5</span>
                <span class="tech-badge">CSS3</span>
                <span class="tech-badge">PHP 8</span>
                <span class="tech-badge">MySQL</span>
            </div>

            <hr>

            <div class="project-info">
                <h3>Kantin Digital Skomda</h3>
                <p>Sistem ini dirancang untuk meminimalisir kesalahan pencatatan pesanan, mempercepat proses antrean, dan menyediakan data inventaris makanan secara real-time bagi pengelola kantin dan siswa.</p>
            </div>

            <a href="index.php" class="btn-back">Kembali ke Beranda</a>
        </div>
    </main>

</body>

</html>

<?php include 'includes/footer.php'; ?>