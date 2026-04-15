<?php
session_start();
// hapus semua data session
session_destroy();
// balikkan ke halaman login
header("location:login.php");
?>