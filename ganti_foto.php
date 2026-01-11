<?php 
session_start();
if($_SESSION['status']!="login"){
    header("location:index.php?pesan=belum_login");
}
include 'koneksi.php';

$pesan = "";
if(isset($_POST['upload'])){
    
    $nama_file = $_FILES['foto']['name'];
    $tmp_file  = $_FILES['foto']['tmp_name'];
    $tipe_file = $_FILES['foto']['type'];
    $ukuran    = $_FILES['foto']['size'];
    
    $folder    = "assets/"; 
    $gambar_valid = ['image/jpeg', 'image/png', 'image/jpg'];
    
    if(!in_array($tipe_file, $gambar_valid)){
        $pesan = "<div class='alert alert-danger'>Format file harus JPG, JPEG, atau PNG!</div>";
    
    // --- PERUBAHAN DI SINI (UBAH KE 5MB) ---
    } elseif($ukuran > 5242880) {
        $pesan = "<div class='alert alert-danger'>Ukuran file terlalu besar! Maksimal 5MB.</div>";
    // ---------------------------------------

    } else {
        // === FITUR BARU: NAMA FILE UNIK ===
        $nama_baru = $_SESSION['id_user'] . "_" . time() . "_" . $nama_file;
        $tujuan = $folder . $nama_baru;
        
        if(move_uploaded_file($tmp_file, $tujuan)){
            
            // Update Database
            $id = $_SESSION['id_user'];
            $query = mysqli_query($koneksi, "UPDATE users SET foto='$nama_baru' WHERE id='$id'");
            
            if($query){
                $pesan = "<div class='alert alert-success'>Foto berhasil diganti!</div>";
                
                // === FITUR BARU: AUTO UPDATE SESSION ===
                $_SESSION['foto'] = $nama_baru; 
                
            } else {
                $pesan = "<div class='alert alert-warning'>Gagal update database.</div>";
            }
            
        } else {
            $pesan = "<div class='alert alert-danger'>Gagal upload file.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganti Foto Profil</title>
    <link rel="icon" type="image/png" href="assets/prut.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f0f2f5; font-family: 'Poppins', sans-serif; }
        .card-upload { max-width: 500px; margin: 50px auto; border-radius: 15px; box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <div class="container">
        <div class="card card-upload p-4">
            <h4 class="text-center mb-4"><i class="fas fa-camera text-primary"></i> Ganti Foto Profil</h4>
            <?php echo $pesan; ?>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="mb-3 text-center">
                    <?php 
                        $foto_sekarang = "assets/prut.png";
                        if(isset($_SESSION['foto']) && $_SESSION['foto']!=""){
                            $foto_sekarang = "assets/" . $_SESSION['foto'];
                        }
                    ?>
                    <img src="<?php echo $foto_sekarang; ?>" class="rounded-circle mb-3 shadow" style="width: 100px; height: 100px; object-fit: cover;">
                    
                    <p class="text-muted small">Format: JPG/PNG, Max: 5MB</p>
                    
                </div>
                <div class="mb-4">
                    <label for="foto" class="form-label">Pilih Foto Baru</label>
                    <input type="file" class="form-control" name="foto" id="foto" required>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" name="upload" class="btn btn-primary"><i class="fas fa-save me-2"></i> Simpan Foto</button>
                    <a href="dashboard" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>