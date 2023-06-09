<?php
// Membuat koneksi ke database secara OOP
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "uasweb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi ke database Gagal: " . $conn->connect_error);
}

// echo "Koneksi berhasil";
?>
