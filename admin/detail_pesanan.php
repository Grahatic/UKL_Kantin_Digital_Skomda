<?php
session_start();
include '../config/koneksi.php';

// cek session
if (!isset($_SESSION['id_stand'])) {
    echo "<h1 style='color:red;'>MASALAH KETEMU: Lu belum login atau session id_stand kosong!</h1>";
    echo "Isi session lu saat ini: <pre>"; print_r($_SESSION); echo "</pre>";
    exit;
}

$id_s = $_SESSION['id_stand'];
echo "<h3>Log: Lu login sebagai Admin Stand ID: " . $id_s . "</h3>";

// query yang sudah disesuaikan dengan databse
$query = "SELECT DISTINCT t.*, u.username 
          FROM transaksi t
          JOIN user u ON t.id_user = u.id_user
          JOIN detail_transaksi dt ON t.id_transaksi = dt.id_transaksi
          JOIN menu m ON dt.id_menu = m.id_menu
          WHERE m.id_stand = '$id_s'";

$sql = mysqli_query($conn, $query);
?>

<table border="1" cellpadding="10">
    <tr style="background: yellow;">
        <th>ID Transaksi</th>
        <th>Nama Siswa</th>
        <th>Total</th>
        <th>Status</th>
    </tr>
    <?php 
    if(mysqli_num_rows($sql) == 0) {
        echo "<tr><td colspan='4'>Database lu ada isinya, tapi query ini nggak nemu hasil yang cocok.</td></tr>";
    }
    while($d = mysqli_fetch_array($sql)){ 
    ?>
    <tr>
        <td><?php echo $d['id_transaksi']; ?></td>
        <td><?php echo $d['username']; ?></td>
        <td><?php echo $d['total_bayar']; ?></td>
        <td><?php echo $d['status']; ?></td>
    </tr>
    <?php } ?>
</table>