<?php
session_start();
include 'koneksi.php';

// Cek apakah sudah login
if ($_SESSION['status'] != "login") {
    header("location:index.php?pesan=belum_login");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Stok Barang</title>
    <link rel="icon" type="image/png" href="assets/prut.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Daftar Inventaris Barang</h2>
        <p class="text-muted">Halaman ini hanya untuk melihat stok, tidak bisa mengubah data.</p>
        <hr>
        
        <a href="dashboard" class="btn btn-secondary mb-3">Kembali ke Dashboard</a>

        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Lokasi</th>
                    <th>Kondisi</th>
                    <th>Stok</th>
                    </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $data = mysqli_query($koneksi, "SELECT * FROM barang ORDER BY id DESC");
                while ($d = mysqli_fetch_array($data)) {
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $d['kode_barang']; ?></td>
                    <td><?php echo $d['nama_barang']; ?></td>
                    <td><?php echo $d['kategori']; ?></td>
                    <td><?php echo $d['lokasi']; ?></td>
                    <td>
                        <span class="badge bg-<?php echo ($d['kondisi'] == 'Baik') ? 'success' : 'danger'; ?>">
                            <?php echo $d['kondisi']; ?>
                        </span>
                    </td>
                    <td><?php echo $d['stok']; ?> Unit</td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function () {
        $('table').DataTable();
    });
</script>
</body>
</html>