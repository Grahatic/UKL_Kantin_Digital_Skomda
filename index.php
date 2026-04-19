<?php
// memanggil header yang sudah berisi session_start dan proteksi akun
include 'includes/header_siswa.php';

// menghubungkan file ke database menggunakan variabel dari header
include 'config/koneksi.php';
?>

<main class="main-content">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        
        <div class="hero-box" style="background: #ce1212; border-radius: 20px; padding: 50px 40px; margin-bottom: 30px; text-align: left;">
            <h1 style="color: white; font-size: 2.2rem; font-weight: 800; margin: 0;">Mau Makan Apa Hari Ini?</h1>
        </div>

        <div class="filter-wrapper" style="display: flex; gap: 12px; margin-bottom: 30px; overflow-x: auto; padding-bottom: 10px;">
            <a href="index.php" class="btn-filter <?php echo !isset($_GET['stand']) ? 'active' : ''; ?>">Semua</a>
            
            <?php
            $ambil_stand = mysqli_query($conn, "SELECT * FROM stand");
            while($s = mysqli_fetch_array($ambil_stand)){
                $status_aktif = (isset($_GET['stand']) && $_GET['stand'] == $s['id_stand']) ? 'active' : '';
            ?>
                <a href="index.php?stand=<?php echo $s['id_stand']; ?>" class="btn-filter <?php echo $status_aktif; ?>">
                    <?php echo $s['nama_stand']; ?>
                </a>
            <?php } ?>
        </div>

        <div class="menu-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 25px;">
            <?php
            // Logika filter stand
            $where_clause = "";
            if(isset($_GET['stand'])) {
                $id_s = $_GET['stand'];
                $where_clause = "WHERE id_stand = '$id_s'";
            }
            
            $ambil_menu = mysqli_query($conn, "SELECT * FROM menu $where_clause ORDER BY id_menu DESC");
            while ($m = mysqli_fetch_array($ambil_menu)) {
                // Variabel bantuan untuk cek stok
                $is_habis = ($m['stok'] <= 0);
            ?>
                <div class="menu-card" style="background: white; border-radius: 15px; box-shadow: 0 10px 20px rgba(0,0,0,0.05); overflow: hidden; position: relative;">
                    
                    <?php if ($is_habis) : ?>
                        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 200px; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; z-index: 2;">
                            <span style="color: white; font-weight: bold; border: 2px solid white; padding: 5px 15px; border-radius: 5px; transform: rotate(-15deg); font-size: 1.2rem;">SOLD OUT</span>
                        </div>
                    <?php endif; ?>

                    <div class="menu-image">
                        <img src="assets/img/<?php echo $m['gambar']; ?>" 
                             style="width: 100%; height: 200px; object-fit: cover; filter: <?php echo $is_habis ? 'grayscale(100%)' : 'none'; ?>;">
                    </div>
                    
                    <div class="menu-info" style="padding: 20px;">
                        <h3 style="margin: 0 0 5px 0; font-size: 1.1rem;"><?php echo $m['nama_menu']; ?></h3>
                        
                        <p style="font-size: 0.85rem; color: <?php echo $is_habis ? 'red' : '#666'; ?>; margin-bottom: 8px;">
                            Sisa Stok: <strong><?php echo $m['stok']; ?></strong> porsi
                        </p>
                        
                        <p style="color: #ce1212; font-weight: bold; margin-bottom: 15px; font-size: 1.1rem;">
                            Rp <?php echo number_format($m['harga'], 0, ',', '.'); ?>
                        </p>
                        
                        <?php if ($is_habis) : ?>
                            <span style="display: block; text-align: center; background: #ccc; color: white; padding: 12px; border-radius: 8px; font-weight: bold; cursor: not-allowed;">Stok Habis</span>
                        <?php else : ?>
                            <a href="beli.php?id=<?php echo $m['id_menu']; ?>" 
                               style="display: block; text-align: center; background: #ce1212; color: white; padding: 12px; border-radius: 8px; text-decoration: none; font-weight: bold;">Pesan</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</main>

<?php
include 'includes/footer.php';
?>