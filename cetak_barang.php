<?php
// 1. NYALAKAN LAPORAN ERROR (Supaya ketahuan kalau ada salah)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 2. PANGGIL LIBRARY FPDF
// Pastikan file fpdf.php ada di folder yang sama!
if (!file_exists('fpdf.php')) {
    die("Error: File fpdf.php tidak ditemukan! Pastikan sudah di-upload.");
}
require('fpdf.php');

// 3. PANGGIL KONEKSI DATABASE
// Kita pakai file koneksi.php kamu yang sudah jalan, biar gak salah password
if (!file_exists('koneksi.php')) {
    die("Error: File koneksi.php tidak ditemukan!");
}
include 'koneksi.php';

// 4. MEMBUAT HALAMAN PDF
$pdf = new FPDF('L','mm','A4');
$pdf->AddPage();

// Header
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'DATA INVENTARIS BARANG',0,1,'C');
$pdf->SetFont('Arial','I',10);
$pdf->Cell(0,10,'Laporan Sistem Sarana Prasarana',0,1,'C');
$pdf->Ln(5);

// Header Tabel
$pdf->SetFont('Arial','B',10);
$pdf->SetFillColor(230,230,230);

$pdf->Cell(10,10,'No',1,0,'C',true);
$pdf->Cell(25,10,'Kode',1,0,'C',true);
$pdf->Cell(70,10,'Nama Barang',1,0,'C',true);
$pdf->Cell(35,10,'Kategori',1,0,'C',true);
$pdf->Cell(30,10,'Tgl Masuk',1,0,'C',true);
$pdf->Cell(35,10,'Lokasi',1,0,'C',true);
$pdf->Cell(25,10,'Kondisi',1,0,'C',true);
$pdf->Cell(20,10,'Stok',1,1,'C',true);

// 5. ISI TABEL DARI DATABASE
$pdf->SetFont('Arial','',10);
$no = 1;

// PENTING: Variabel koneksi di file koneksi.php kamu biasanya bernama $koneksi
// Jadi kita pakai $koneksi di sini
$data = mysqli_query($koneksi, "SELECT * FROM barang ORDER BY id DESC");

while($d = mysqli_fetch_array($data)){
    $pdf->Cell(10,10, $no++, 1,0,'C');
    $pdf->Cell(25,10, $d['kode_barang'], 1,0,'C');
    $pdf->Cell(70,10, $d['nama_barang'], 1,0,'L');
    $pdf->Cell(35,10, $d['kategori'], 1,0,'L');
    
    // Format Tanggal
    $tgl = $d['tgl_masuk'];
    if($tgl == '0000-00-00' || $tgl == null) { $tgl = '-'; }
    $pdf->Cell(30,10, $tgl, 1,0,'C');
    
    $pdf->Cell(35,10, $d['lokasi'], 1,0,'L');
    $pdf->Cell(25,10, $d['kondisi'], 1,0,'C');
    $pdf->Cell(20,10, $d['stok'], 1,1,'C'); 
}
// --- AREA TANDA TANGAN ---
$pdf->Ln(15); // Memberi jarak spasi dari tabel ke tanda tangan

// Menentukan posisi di kanan (A4 Landscape lebarnya 297mm)
// Kita atur posisi X di 230mm supaya ada di kanan
$pdf->SetX(230);
$pdf->SetFont('Arial','',10);
$pdf->Cell(50,5,'Menyetujui,',0,1,'C'); // 0,1 artinya border 0, pindah baris 1

$pdf->SetX(230);
$pdf->Cell(50,5,'Waka. Sarpras',0,1,'C');

// Memberi jarak kosong ke bawah untuk tanda tangan
$pdf->Ln(20); 

$pdf->SetX(230);
$pdf->SetFont('Arial','B',10); // Ubah font jadi Tebal (Bold) untuk nama
$pdf->Cell(50,5,'Santang Sunandar',0,1,'C');
// --- AKHIR AREA TANDA TANGAN ---

// 6. OUTPUT
$pdf->Output();
?>