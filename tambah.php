<?php
include 'koneksi.php';

// Inisialisasi variabel
$kode = "";
$nama = "";
$kategori = "";
$lokasi = "";
$kondisi = "";
$stok = "";
$tgl_masuk = date('Y-m-d'); // Default tanggal hari ini
$pesan_error = "";

if (isset($_POST['simpan'])) {
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $lokasi = $_POST['lokasi'];
    $kondisi = $_POST['kondisi'];
    $stok = $_POST['stok'];
    $tgl_masuk = $_POST['tgl_masuk']; // Tangkap data tanggal

    // Cek Duplikat
    $cek = mysqli_query($koneksi, "SELECT * FROM barang WHERE kode_barang='$kode'");
    
    if (mysqli_num_rows($cek) > 0) {
        $pesan_error = "KODE UDAH DIPAKE,GANTI KODE LAIN,NYUSAHIN AJA";
    } else {
        // Simpan Data (Perhatikan ada $tgl_masuk di akhir)
        mysqli_query($koneksi, "INSERT INTO barang VALUES(NULL, '$kode', '$nama', '$kategori', '$lokasi', '$kondisi', '$stok', '$tgl_masuk')");
        header("location:barang.php");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Barang</title>
    <link rel="icon" type="image/png" href="assets/prut.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 600px;">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Tambah Barang Baru</h4>
            </div>
            <div class="card-body">
                
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Kode Barang</label>
                        <div class="input-group has-validation">
                            <input type="text" name="kode" class="form-control <?php echo ($pesan_error != "") ? 'is-invalid' : ''; ?>" value="<?php echo $kode; ?>" required>
                            <?php if ($pesan_error != "") { ?>
                                <div class="invalid-feedback fw-bold text-uppercase"><?php echo $pesan_error; ?> !!!</div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Barang</label>
                        <input type="text" name="nama" class="form-control" value="<?php echo $nama; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="kategori" class="form-control">
                            <option value="Elektronik" <?php if($kategori == "Elektronik") echo "selected"; ?>>Elektronik</option>
                            <option value="Furniture" <?php if($kategori == "Furniture") echo "selected"; ?>>Furniture</option>
                            <option value="ATK" <?php if($kategori == "ATK") echo "selected"; ?>>ATK</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Tahun/Tanggal Masuk</label>
                        <input type="date" name="tgl_masuk" class="form-control" value="<?php echo $tgl_masuk; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Lokasi</label>
                        <input type="text" name="lokasi" class="form-control" value="<?php echo $lokasi; ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kondisi</label>
                        <select name="kondisi" class="form-control">
                            <option value="Baik" <?php if($kondisi == "Baik") echo "selected"; ?>>Baik</option>
                            <option value="Rusak" <?php if($kondisi == "Rusak") echo "selected"; ?>>Rusak</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Jumlah Stok</label>
                        <input type="number" name="stok" class="form-control" value="<?php echo $stok; ?>">
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" name="simpan" class="btn btn-primary">Simpan Data</button>
                        <a href="barang" class="btn btn-secondary">Batal</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</body>
</html>