-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql303.infinityfree.com
-- Waktu pembuatan: 11 Jan 2026 pada 03.03
-- Versi server: 11.4.9-MariaDB
-- Versi PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_40795656_Sarpras`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `kode_barang` varchar(20) DEFAULT NULL,
  `nama_barang` varchar(100) DEFAULT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `lokasi` varchar(50) DEFAULT NULL,
  `kondisi` varchar(20) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  `tgl_masuk` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id`, `kode_barang`, `nama_barang`, `kategori`, `lokasi`, `kondisi`, `stok`, `tgl_masuk`) VALUES
(9, '001', 'PC', 'Elektronik', 'WAKA', 'Baik', 20, '2026-01-02'),
(10, '002', 'switch', 'Elektronik', 'SIM', 'Baik', 10, '2026-01-02');

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` int(11) NOT NULL,
  `nama_peminjam` varchar(100) DEFAULT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `tgl_pinjam` date DEFAULT NULL,
  `tgl_kembali` date DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Dipinjam'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `peminjaman`
--

INSERT INTO `peminjaman` (`id`, `nama_peminjam`, `id_barang`, `jumlah`, `tgl_pinjam`, `tgl_kembali`, `status`) VALUES
(1, 'riski', 2, 8, '2025-12-30', '2025-12-30', 'Dikembalikan'),
(2, 'riski', 7, 10, '2025-12-31', '2025-12-31', 'Dikembalikan'),
(3, 'Joko', 8, 15, '2026-01-01', '2026-01-01', 'Dikembalikan'),
(4, 'dito', 8, 5, '2026-01-01', '2026-01-01', 'Dikembalikan'),
(5, 'dito', 7, 2, '2026-01-01', '2026-01-01', 'Dikembalikan'),
(6, 'bebe', 7, 4, '2026-01-01', '2026-01-01', 'Dikembalikan'),
(7, 'Umie', 9, 10, '2026-01-02', '2026-01-02', 'Dikembalikan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `level` varchar(20) DEFAULT 'petugas',
  `foto` varchar(255) DEFAULT 'default.png',
  `token_login` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama_lengkap`, `level`, `foto`, `token_login`) VALUES
(1, 'admin', 'cfb30220f8260a8f1e8cd92b0363d93d', 'Administrator', 'admin', '1_1767198333_Screenshot 2025-11-29 171823.png', '9ad64cf839675cfec58b44d32d213f57'),
(3, 'Japrut', '827ccb0eea8a706c4c34a16891f84e7b', 'Hamzah Abdillah, S.Pd.', 'admin', 'default.png', ''),
(7, 'Termul', '01cfcd4f6b8770febfb40cb906715822', 'Jokowi', 'petugas', 'default.png', ''),
(8, 'andri', '6ebe76c9fb411be97b3b0d48b791a7c9', 'Bertus', 'petugas', 'default.png', '');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
