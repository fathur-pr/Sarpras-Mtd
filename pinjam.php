<?php
include 'koneksi.php';

if (isset($_POST['pinjam'])) {
    $peminjam = $_POST['peminjam'];
    $id_barang = $_POST['barang'];
    $jumlah = $_POST['jumlah'];
    $tgl_pinjam = date('Y-m-d');

    // 1. Cek dulu stok barangnya cukup gak?
    $cek_stok = mysqli_query($koneksi, "SELECT stok FROM barang WHERE id='$id_barang'");
    $data_stok = mysqli_fetch_assoc($cek_stok);

    if ($data_stok['stok'] < $jumlah) {
        echo "<script>alert('Stok barang tidak cukup!'); window.location='pinjam.php';</script>";
    } else {
        // 2. Kurangi Stok di tabel barang
        mysqli_query($koneksi, "UPDATE barang SET stok = stok - $jumlah WHERE id='$id_barang'");

        // 3. Masukkan data ke tabel peminjaman
        mysqli_query($koneksi, "INSERT INTO peminjaman (nama_peminjam, id_barang, jumlah, tgl_pinjam, status) 
                                VALUES ('$peminjam', '$id_barang', '$jumlah', '$tgl_pinjam', 'Dipinjam')");
        
        header("location:peminjaman");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pinjam Barang</title>
    <link rel="icon" type="image/png" href="assets/prut.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5" style="max-width: 500px;">
        <h3>Form Peminjaman</h3>
        <form method="POST">
            <div class="mb-3">
                <label>Nama Peminjam</label>
                <input type="text" name="peminjam" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Pilih Barang</label>
                <select name="barang" class="form-control" required>
                    <option value="">-- Pilih Barang --</option>
                    <?php
                    $ambil = mysqli_query($koneksi, "SELECT * FROM barang WHERE stok > 0");
                    while($b = mysqli_fetch_array($ambil)){
                        echo "<option value='".$b['id']."'>".$b['nama_barang']." (Stok: ".$b['stok'].")</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Jumlah Pinjam</label>
                <input type="number" name="jumlah" class="form-control" min="1" required>
            </div>
            <button type="submit" name="pinjam" class="btn btn-primary">Simpan Peminjaman</button>
            <a href="peminjaman" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>
</html>