<?php
// memulai session dan proteksi halaman melalui header khusus siswa
include 'includes/header_siswa.php';

// menghubungkan file ke database agar bisa manipulasi data
include 'config/koneksi.php';

// menangkap ID user yang sedang login dari session untuk filter keranjang
$id_user = $_SESSION['id_user'];
?>

<section style="padding: 40px 5%; min-height: 60vh;">
    <div class="container">
        <h2>Keranjang Belanja Kamu</h2><br>
        
        <table border="1" cellpadding="10" cellspacing="0" width="100%" style="border-collapse: collapse;">
            <thead>
                <tr style="background-color: #ce1212; color: white;">
                    <th>Nama Menu</th>
                    <th>Harga Satuan</th>
                    <th>Jumlah Beli</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // mengambil data keranjang yang di-join dengan tabel menu untuk mendapatkan nama dan harga
                $query = "SELECT keranjang.*, menu.nama_menu, menu.harga 
                          FROM keranjang 
                          JOIN menu ON keranjang.id_menu = menu.id_menu 
                          WHERE keranjang.id_user = '$id_user'";
                
                $sql = mysqli_query($conn, $query);
                $total = 0;

                // melakukan looping untuk menampilkan setiap item di dalam keranjang
                while ($data = mysqli_fetch_array($sql)) {
                    // Menghitung subtotal per item (harga x jumlah)
                    $subtotal = $data['harga'] * $data['qty'];
                    // menambahkan subtotal ke variabel total bayar
                    $total += $subtotal;
                    ?>
                    <tr>
                        <td><?php echo $data['nama_menu']; ?></td>
                        <td>Rp <?php echo number_format($data['harga'], 0, ',', '.'); ?></td>
                        <td align="center"><?php echo $data['qty']; ?></td>
                        <td>Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
            <tfoot>
                <tr style="font-weight: bold; background-color: #f4f4f4;">
                    <td colspan="3" align="right">Total yang harus dibayar:</td>
                    <td>Rp <?php echo number_format($total, 0, ',', '.'); ?></td>
                </tr>
            </tfoot>
        </table>

        <br>
        <?php if ($total > 0): ?>
            <a href="checkout.php" style="background: #ce1212; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; float: right; font-weight: bold;">Konfirmasi & Pesan Sekarang</a>
        <?php else: ?>
            <p style="color: red; text-align: right; font-style: italic;">Keranjang kosong, silakan pilih menu dulu.</p>
        <?php endif; ?>
    </div>
</section>

<?php
// memanggil file footer untuk menutup struktur HTML
include 'includes/footer.php';
?>