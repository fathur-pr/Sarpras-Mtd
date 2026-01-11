<?php 
// --- TAMBAHKAN KODE INI ---
ini_set('display_errors', 1);
error_reporting(E_ALL);
// --------------------------

session_start();
include 'koneksi.php';

// ... (lanjutan codingan kamu ke bawah) ...
// --- TAMBAHKAN INI ---
ini_set('display_errors', 1);
error_reporting(E_ALL);
// ---------------------

// ... kodingan asli kamu di bawahnya ...
ini_set('session.gc_maxlifetime', 86400);
// dst...
// 1. SETTING SESI ABADI (24 JAM)
ini_set('session.gc_maxlifetime', 86400);
session_set_cookie_params(86400);
session_start();

include 'koneksi.php';
 
$username = $_POST['username'];
$password = md5($_POST['password']);
 
// Cek User
$login = mysqli_query($koneksi, "select * from users where username='$username' and password='$password'");
$cek = mysqli_num_rows($login);
 
if($cek > 0){
    $data = mysqli_fetch_assoc($login);

    // === STRICT MODE: Cek Token Database ===
    // Kalau token isi, tolak!
    if($data['token_login'] != "" && $data['token_login'] != NULL){
        header("location:index.php?pesan=sedang_login");
        exit;
    }
    // =======================================

    // Kalau kosong, Buat Token Baru
    $token_baru = md5(date('Y-m-d H:i:s') . rand(100, 999));
    
    // Simpan ke Database
    $id_user = $data['id']; 
    mysqli_query($koneksi, "UPDATE users SET token_login='$token_baru' WHERE id='$id_user'");

    // Simpan ke Session (Tiket ini sekarang tahan 24 jam!)
    $_SESSION['token_login'] = $token_baru;
    $_SESSION['id_user'] = $id_user;
    $_SESSION['username'] = $username;
    $_SESSION['nama'] = $data['nama_lengkap'];
    $_SESSION['foto'] = $data['foto'];
    $_SESSION['level'] = $data['level'];
    $_SESSION['status'] = "login";
 
	header("location:dashboard");
}else{
	header("location:index?pesan=gagal");
}
?>