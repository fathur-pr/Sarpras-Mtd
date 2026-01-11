<?php
// 1. WAJIB ADA SESSION START (Biar bisa titip pesan)
session_start();
include 'koneksi.php';

$id_pinjam = $_GET['id'];
$tgl_kembali = date('Y-m-d');

// Ambil data peminjaman
$query = mysqli_query($koneksi, "SELECT * FROM peminjaman WHERE id='$id_pinjam'");
$data = mysqli_fetch_assoc($query);

$id_barang = $data['id_barang'];
$jumlah = $data['jumlah'];

// Balikkan Stok Barang
mysqli_query($koneksi, "UPDATE barang SET stok = stok + $jumlah WHERE id='$id_barang'");

// Update Status Peminjaman
$update = mysqli_query($koneksi, "UPDATE peminjaman SET status='Dikembalikan', tgl_kembali='$tgl_kembali' WHERE id='$id_pinjam'");

if($update) {
    // --- FITUR BARU: SIMPAN PESAN SUKSES KE SESSION ---
    $_SESSION['info'] = 'sukses';
}

// Redirect (Hapus .php sesuai request URL bersih sebelumnya)
header("location:peminjaman");
?>