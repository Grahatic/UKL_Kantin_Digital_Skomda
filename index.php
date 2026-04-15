<?php
// panggil file header yang udah ada session_start dan proteksi
include 'includes/header.php';
// panggil koneksi database
include 'config/koneksi.php';
?>

<section>
    <h2>Mau Makan Apa Hari Ini?</h2>
    
    <div class="container-menu">
        <?php
        // ambil data semua menu dari database
        $query = mysqli_query($conn, "SELECT * FROM menu");
        // looping buat nampilin tiap menu
        while($d = mysqli_fetch_array($query)){
            ?>
            <div class="card">
                <img src="assets/img/<?php echo $d['gambar']; ?>" width="100">
                <h3><?php echo $d['nama_menu']; ?></h3>
                <p>Rp <?php echo number_format($d['harga']); ?></p>
                <a href="beli.php?id=<?php echo $d['id_menu']; ?>">Pesan Sekarang</a>
            </div>
            <?php
        }
        ?>
    </div>
</section>

<?php
// panggil file footer buat nutup halaman
include 'includes/footer.php';
?>