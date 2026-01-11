<?php
include 'koneksi.php';
$id = $_GET['id'];
$data = mysqli_query($koneksi, "SELECT * FROM barang WHERE id='$id'");
$d = mysqli_fetch_array($data);

if (isset($_POST['update'])) {
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $lokasi = $_POST['lokasi'];
    $kondisi = $_POST['kondisi'];
    $stok = $_POST['stok'];
    $tgl_masuk = $_POST['tgl_masuk']; // Tangkap tanggal baru

    // Update Query (Tambahkan tgl_masuk)
    mysqli_query($koneksi, "UPDATE barang SET kode_barang='$kode', nama_barang='$nama', kategori='$kategori', lokasi='$lokasi', kondisi='$kondisi', stok='$stok', tgl_masuk='$tgl_masuk' WHERE id='$id'");
    header("location:barang.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Barang</title>
    <link rel="icon" type="image/png" href="assets/prut.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 600px;">
        <div class="card shadow">
            <div class="card-header bg-warning">
                <h4 class="mb-0">Edit Data Barang</h4>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-2"><label>Kode Barang</label><input type="text" name="kode" class="form-control" value="<?php echo $d['kode_barang']; ?>"></div>
                    <div class="mb-2"><label>Nama Barang</label><input type="text" name="nama" class="form-control" value="<?php echo $d['nama_barang']; ?>"></div>
                    <div class="mb-2"><label>Kategori</label>
                        <select name="kategori" class="form-control">
                            <option value="Elektronik" <?php if($d['kategori']=='Elektronik') echo 'selected'; ?>>Elektronik</option>
                            <option value="Furniture" <?php if($d['kategori']=='Furniture') echo 'selected'; ?>>Furniture</option>
                            <option value="ATK" <?php if($d['kategori']=='ATK') echo 'selected'; ?>>ATK</option>
                        </select>
                    </div>
                    
                    <div class="mb-2">
                        <label>Tahun Masuk</label>
                        <input type="date" name="tgl_masuk" class="form-control" value="<?php echo $d['tgl_masuk']; ?>">
                    </div>

                    <div class="mb-2"><label>Lokasi</label><input type="text" name="lokasi" class="form-control" value="<?php echo $d['lokasi']; ?>"></div>
                    <div class="mb-2"><label>Kondisi</label>
                        <select name="kondisi" class="form-control">
                            <option value="Baik" <?php if($d['kondisi']=='Baik') echo 'selected'; ?>>Baik</option>
                            <option value="Rusak" <?php if($d['kondisi']=='Rusak') echo 'selected'; ?>>Rusak</option>
                        </select>
                    </div>
                    <div class="mb-4"><label>Stok</label><input type="number" name="stok" class="form-control" value="<?php echo $d['stok']; ?>"></div>
                    
                    <button type="submit" name="update" class="btn btn-success w-100">Update Data</button>
                    <a href="barang" class="btn btn-secondary w-100 mt-2">Batal</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>