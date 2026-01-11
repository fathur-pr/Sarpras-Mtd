<?php
$host = "localhost";
$user = "root";       // XAMPP user-nya root
$pass = "";           // XAMPP password-nya KOSONG
$db   = "sarpras";    // Sesuai nama DB yang tadi kamu Import (kecil semua)

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (mysqli_connect_errno()) {
    echo "Koneksi Database Gagal : " . mysqli_connect_error();
    exit(); // Biar stop disini kalau gagal
}
?>