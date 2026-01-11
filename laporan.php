<?php
include 'koneksi.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Sarpras</title>
    <link rel="icon" type="image/png" href="assets/prut.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Laporan Peminjaman Barang</h2>
        <hr>
        <a href="dashboard" class="btn btn-secondary mb-3">Kembali</a>
        
        <div class="card">
            <div class="card-body">
                <form method="GET" action="cetak.php" target="_blank">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Dari Tanggal</label>
                            <input type="date" name="tgl_awal" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label>Sampai Tanggal</label>
                            <input type="date" name="tgl_akhir" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label>&nbsp;</label><br>
                            <button type="submit" class="btn btn-primary w-100">Cetak PDF</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="alert alert-info mt-3">
            <strong>Info:</strong> Silakan pilih tanggal, lalu klik tombol Cetak. Nanti akan terbuka tab baru, pilih <strong>Destination: Save as PDF</strong>.
        </div>
    </div>
</body>
</html>