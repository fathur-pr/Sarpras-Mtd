<?php
session_start();
include 'koneksi.php';

// 1. Cek apakah user sudah login
// Kalau belum login, tendang balik ke halaman index
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("location:index.php");
    exit();
}

// Ambil ID user yang sedang login dari session
$id_user = $_SESSION['id_user']; 

// Ambil data lengkap user dari database berdasarkan ID tadi
$query = mysqli_query($koneksi, "SELECT * FROM users WHERE id='$id_user'");
$data = mysqli_fetch_assoc($query);

// --- LOGIKA UPLOAD FOTO ---
if (isset($_POST['upload'])) {
    $foto_lama = $data['foto'];
    
    // Ambil informasi file yang diupload
    $filename = $_FILES['foto_baru']['name'];
    $tmp_name = $_FILES['foto_baru']['tmp_name'];
    $ekstensi = pathinfo($filename, PATHINFO_EXTENSION);
    
    // Validasi: Hanya boleh format gambar tertentu
    $allowed = array('jpg', 'jpeg', 'png', 'gif');
    if(!in_array(strtolower($ekstensi), $allowed)) {
        // Jika format salah, munculkan pesan error
        echo "<script>alert('Format file harus JPG, JPEG, atau PNG!');</script>";
    } else {
        // Jika format benar, buat nama file baru yang unik
        // Format nama: user_[ID]_[WAKTU].[EKSTENSI] -> Contoh: user_1_167889900.jpg
        $nama_baru = "user_" . $id_user . "_" . time() . "." . $ekstensi;
        $tujuan = 'uploads/' . $nama_baru;

        // Proses memindahkan file dari folder sementara ke folder 'uploads'
        if (move_uploaded_file($tmp_name, $tujuan)) {
            
            // 1. Update nama file foto di Database
            mysqli_query($koneksi, "UPDATE users SET foto='$nama_baru' WHERE id='$id_user'");
            
            // 2. Hapus foto lama dari folder (biar gak menuh-menuhin hardisk)
            // Hapus cuma kalau foto lamanya bukan 'default.png' dan filenya ada
            if ($foto_lama != 'default.png' && file_exists('uploads/'.$foto_lama)) {
                unlink('uploads/'.$foto_lama);
            }

            // 3. Update Session Foto biar tampilan di pojok kanan atas langsung berubah
            $_SESSION['foto'] = $nama_baru;
            
            // Berhasil! Redirect kembali ke dashboard
            echo "<script>alert('Foto berhasil diganti!'); window.location='dashboard.php';</script>";
        } else {
            // Gagal saat proses pemindahan file
            echo "<script>alert('Gagal mengupload file! Pastikan folder uploads ada.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ganti Foto Profil</title>
    <link rel="icon" type="image/png" href="assets/prut.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: #f0f2f5;"> <div class="container mt-5">
        <div class="card mx-auto shadow" style="max-width: 500px;">
            <div class="card-header bg-primary text-white text-center fw-bold">
                Ganti Foto Profil
            </div>
            <div class="card-body text-center p-4">
                
                <?php 
                    // Cek apakah file fotonya ada di folder uploads
                    $foto_profil = "uploads/" . ($data['foto'] ?? 'default.png');
                    if (!file_exists($foto_profil)) { 
                        // Jika file fisik tidak ditemukan, pakai default
                        $foto_profil = "uploads/default.png"; 
                    }
                ?>
                <img src="<?php echo $foto_profil; ?>" class="rounded-circle mb-3 border border-3 border-primary" width="150" height="150" style="object-fit: cover;">
                
                <h4 class="fw-bold"><?php echo $data['nama_lengkap']; ?></h4>
                <p class="badge bg-secondary"><?php echo strtoupper($data['level']); ?></p>
                <hr>

                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-4 text-start">
                        <label for="formFile" class="form-label fw-bold">Pilih Foto Baru Sendiri</label>
                        <input class="form-control" type="file" id="formFile" name="foto_baru" required accept="image/png, image/jpeg, image/gif">
                        <small class="text-muted">Format yang didukung: JPG, PNG, GIF. Foto akan otomatis dipotong bulat.</small>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" name="upload" class="btn btn-primary">Simpan Foto Baru</button>
                        <a href="dashboard" class="btn btn-outline-secondary">Batal / Kembali ke Dashboard</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</body>
</html>