<?php

// memanggil header yang sudah berisi session_start dan proteksi akun siswa
include 'includes/header_siswa.php';

// menghubungkan file ke database
include 'config/koneksi.php';

// mengambil id user dari data session yang aktif
$id_user = $_SESSION['id_user'];
?>

<section style="padding: 40px 5%; min-height: 60vh;">
    <div class="container">
        <h2>Keranjang Belanja Kamu</h2><br>

        <table border="1" cellpadding="10" cellspacing="0" width="100%" style="border-collapse: collapse; border: 1px solid #ddd;">
            <thead>
                <tr style="background-color: #ce1212; color: white;">
                    <th>Nama Menu</th>
                    <th>Harga Satuan</th>
                    <th>Jumlah Beli</th>
                    <th>Subtotal</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php

                // menyusun instruksi query untuk mengambil data keranjang yang dihubungkan dengan tabel menu
                $query = "SELECT keranjang.*, menu.nama_menu, menu.harga, menu.stok 
                          FROM keranjang 
                          JOIN menu ON keranjang.id_menu = menu.id_menu 
                          WHERE keranjang.id_user = '$id_user'";

                // menjalankan instruksi query ke database
                $sql = mysqli_query($conn, $query);

                // inisialisasi variabel total pembayaran akumulatif
                $total = 0;

                // mengambil data dari hasil query menjadi array
                while ($data = mysqli_fetch_array($sql)) {

                    // menghitung subtotal berdasarkan harga satuan dikali kuantitas
                    $subtotal = $data['harga'] * $data['qty'];

                    // menambahkan subtotal ke dalam variabel total keseluruhan
                    $total += $subtotal;
                ?>
                    <tr>
                        <td><?php echo $data['nama_menu']; ?></td>
                        <td>Rp <?php echo number_format($data['harga'], 0, ',', '.'); ?></td>

                        <td align="center">
                            <div style="display: flex; justify-content: center; align-items: center; gap: 10px;">
                                <a href="update_keranjang.php?id=<?php echo $data['id_keranjang']; ?>&aksi=kurang"
                                    style="text-decoration: none; background: #eee; color: #333; padding: 2px 10px; border-radius: 4px; border: 1px solid #ccc; font-weight: bold;">-</a>

                                <span style="font-weight: bold;"><?php echo $data['qty']; ?></span>

                                <a href="update_keranjang.php?id=<?php echo $data['id_keranjang']; ?>&aksi=tambah"
                                    style="text-decoration: none; background: #eee; color: #333; padding: 2px 10px; border-radius: 4px; border: 1px solid #ccc; font-weight: bold;">+</a>
                            </div>
                        </td>

                        <td>Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                        <td align="center">
                            <a href="hapus_keranjang.php?id=<?php echo $data['id_keranjang']; ?>"
                                style="color: #ce1212; font-weight: bold; text-decoration: none;"
                                onclick="return confirm('yakin mau hapus menu ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
            <tfoot>
                <tr style="font-weight: bold; background-color: #f4f4f4;">
                    <td colspan="3" align="right">Total yang harus dibayar:</td>
                    <td colspan="2">Rp <?php echo number_format($total, 0, ',', '.'); ?></td>
                </tr>
            </tfoot>
        </table>

        <br>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">
            <a href="index.php" style="background: #666; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold;">
                ← Tambah Menu Lain
            </a>

            <?php if ($total > 0): ?>
                <a href="checkout.php" onclick="return confirm('Konfirmasi pesanan sekarang?')"
                    style="background: #ce1212; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold;">
                    Konfirmasi & Pesan Sekarang
                </a>
            <?php else: ?>
                <p style="color: red; font-style: italic; margin: 0;">Keranjang kosong, silakan pilih menu dulu.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php
// menghubungkan file ke database
include 'includes/footer.php'; ?>