<?php

// memanggil header yang sudah berisi session_start dan proteksi akun siswa
include 'includes/header_siswa.php';

// menghubungkan file ke database atau komponen lain
include 'config/koneksi.php';

// mengambil id user dari data session yang aktif
$id_user = $_SESSION['id_user'];
?>

<section style="padding: 40px 5%; min-height: 60vh;">
    <div class="container">
        <h2>Riwayat Pesanan Kamu</h2>
        <p>Berikut adalah daftar pesanan yang pernah kamu buat.</p><br>

        <table border="1" cellpadding="10" cellspacing="0" width="100%" style="border-collapse: collapse; border: 1px solid #ddd;">
            <thead>
                <tr style="background-color: #333; color: white;">
                    <th>ID Transaksi</th>
                    <th>Tanggal</th>
                    <th>Detail Menu (Qty)</th>
                    <th>Total Bayar</th>
                </tr>
            </thead>
            <tbody>
                <?php

                // menjalankan instruksi query untuk mengambil data transaksi milik user
                $q_trans = mysqli_query($conn, "SELECT * FROM transaksi WHERE id_user = '$id_user' ORDER BY id_transaksi DESC");

                // validasi jika tidak ditemukan data transaksi dalam database
                if (mysqli_num_rows($q_trans) == 0) {
                    echo "<tr><td colspan='4' align='center'>Belum ada riwayat pesanan.</td></tr>";
                }

                // melakukan perulangan untuk setiap data transaksi yang ditemukan
                while ($t = mysqli_fetch_array($q_trans)) {
                    $id_t = $t['id_transaksi'];
                ?>
                    <tr>
                        <td align="center">#TRX-<?php echo $id_t; ?></td>
                        <td><?php echo date('d M Y', strtotime($t['tgl_transaksi'])); ?></td>
                        <td>
                            <ul style="margin: 0; padding-left: 15px;">
                                <?php

                                // menjalankan instruksi query untuk mengambil detail menu yang dibeli dalam satu transaksi
                                $q_detail = mysqli_query($conn, "SELECT detail_transaksi.*, menu.nama_menu 
                                                                 FROM detail_transaksi 
                                                                 JOIN menu ON detail_transaksi.id_menu = menu.id_menu 
                                                                 WHERE id_transaksi = '$id_t'");

                                // melakukan perulangan untuk menampilkan daftar item dan jumlah belinya
                                while ($d = mysqli_fetch_array($q_detail)) {
                                    echo "<li>" . $d['nama_menu'] . " (x" . $d['qty'] . ")</li>";
                                }
                                ?>
                            </ul>
                        </td>
                        <td style="font-weight: bold;">Rp <?php echo number_format($t['total_bayar'], 0, ',', '.'); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</section>

<?php
// menghubungkan file ke databas
include 'includes/footer.php'; ?>