<?php
// panggil header yang berisi session_start dan proteksi login
include 'includes/header.php';
// panggil koneksi database
include 'config/koneksi.php';

// ambil id_user dari session
$id_user = $_SESSION['id_user'];
?>

<section style="padding: 40px 5%;">
    <h2>Keranjang Belanja Kamu</h2><br>
    
    <table border="1" cellpadding="10" cellspacing="0" width="100%">
        <thead>
            <tr style="background-color: #f4f4f4;">
                <th>nama menu</th>
                <th>harga satuan</th>
                <th>jumlah beli</th>
                <th>subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // ambil data keranjang yang di-join dengan tabel menu
            $query = "SELECT keranjang.*, menu.nama_menu, menu.harga 
                      FROM keranjang 
                      JOIN menu ON keranjang.id_menu = menu.id_menu 
                      WHERE keranjang.id_user = '$id_user'";
            
            $sql = mysqli_query($conn, $query);
            $total = 0;

            // looping untuk menampilkan isi keranjang
            while ($data = mysqli_fetch_array($sql)) {
                $subtotal = $data['harga'] * $data['qty'];
                $total += $subtotal;
                ?>
                <tr>
                    <td><?php echo $data['nama_menu']; ?></td>
                    <td>Rp <?php echo number_format($data['harga']); ?></td>
                    <td><?php echo $data['qty']; ?></td>
                    <td>Rp <?php echo number_format($subtotal); ?></td>
                </tr>
                <?php
            }
            ?>
        </tbody>
        <tfoot>
            <tr style="font-weight: bold; background-color: #eee;">
                <td colspan="3" align="right">total yang harus dibayar:</td>
                <td>Rp <?php echo number_format($total); ?></td>
            </tr>
        </tfoot>
    </table>

    <br>
<?php if ($total > 0): ?>
    <a href="checkout.php" style="background: #ce1212; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; float: right;">konfirmasi & pesan sekarang</a>
<?php else: ?>
    <p style="color: red; text-align: right;">keranjang kosong, silakan pilih menu dulu.</p>
<?php endif; ?>

<?php
// panggil footer
include 'includes/footer.php';
?>