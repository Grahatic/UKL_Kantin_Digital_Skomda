<?php

// memulai session dan proteksi halaman melalui header
include 'includes/header_siswa.php';

// menghubungkan file ke database
include 'config/koneksi.php';
?>

<main class="main-content">
    <div class="container">
        <div class="section-title">
            <h2>Mau Makan Apa Hari Ini?</h2>
            <p>Pilih menu favoritmu dari Kantin Skomda</p>
        </div>

        <div class="menu-grid">
            <?php
            // mengambil data semua menu dari database secara urut dari yang terbaru
            $query = mysqli_query($conn, "SELECT * FROM menu ORDER BY id_menu DESC");

            // melakukan looping untuk menampilkan setiap data menu ke dalam bentuk card
            while ($d = mysqli_fetch_array($query)) {
            ?>
                <div class="menu-card">
                    <div class="menu-image">
                        <img src="assets/img/<?php echo $d['gambar']; ?>" alt="<?php echo $d['nama_menu']; ?>">
                    </div>
                    <div class="menu-info">
                        <h3><?php echo $d['nama_menu']; ?></h3>
                        <span class="price">Rp <?php echo number_format($d['harga'], 0, ',', '.'); ?></span>
                        <a href="beli.php?id=<?php echo $d['id_menu']; ?>" class="btn-pesan">Pesan Sekarang</a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</main>

<?php

// memanggil file footer
include 'includes/footer.php';
?>