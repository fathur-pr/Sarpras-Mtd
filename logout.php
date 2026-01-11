<?php 
session_start();
include 'koneksi.php';

// Hapus jejak login di database (PENTING!)
if(isset($_SESSION['id_user'])){
    $id = $_SESSION['id_user'];
    
    // Kita update token jadi KOSONG ('') biar user bisa login lagi nanti
    $update = mysqli_query($koneksi, "UPDATE users SET token_login='' WHERE id='$id'");
}

// Hapus Sesi di Browser
session_destroy();
 
// Balik ke halaman login
header("location:index?pesan=logout");
exit;
?>