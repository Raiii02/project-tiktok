<!-- logout.php -->
<?php
session_start();
// Hapus session yang telah dibuat
session_destroy();
// Redirect ke halaman utama
header("Location: index.php");
exit;
?>