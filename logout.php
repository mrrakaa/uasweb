<?php 
session_start();
require "koneksi.php";

// Memeriksa apakah pengguna sudah login atau belum
if (empty($_SESSION['login'])) {
  header('Location: login');
  exit;
}

// Menghapus semua data session
session_unset();
session_destroy();

// Menghapus cookie
setcookie('login', '', time() - 3600);
setcookie('level', '', time() - 3600);
setcookie('id', '', time() - 3600);
setcookie('key', '', time() - 3600);

// Redirect ke halaman utama
header('Location: index.php');
exit();
?>
