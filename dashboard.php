<?php
// ==============================================================
// 1. FITUR BARU: SESI ABADI (24 JAM) & ANTI-LOGOUT SENDIRI
// ==============================================================
ini_set('session.gc_maxlifetime', 86400);
session_set_cookie_params(86400);
session_start();

include 'koneksi.php'; 

// Cek apakah user sudah login
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("location:index.php?pesan=belum_login");
    exit;
}

// ==============================================================
// 2. LOGIKA LAMA: MENGHITUNG DATA UNTUK DASHBOARD
// ==============================================================

// A. Hitung Total Stok (Total Unit)
$query_stok = mysqli_query($koneksi, "SELECT SUM(stok) as total_stok FROM barang");
$data_stok = mysqli_fetch_assoc($query_stok);
$total_unit = $data_stok['total_stok'];
if($total_unit == null) { $total_unit = 0; }

// B. Hitung Barang Dipinjam
$query_pinjam = mysqli_query($koneksi, "SELECT SUM(jumlah) as total_pinjam FROM peminjaman WHERE status='Dipinjam'");
$data_pinjam = mysqli_fetch_assoc($query_pinjam);
$sedang_dipinjam = $data_pinjam['total_pinjam'];
if($sedang_dipinjam == null) { $sedang_dipinjam = 0; }

// C. Hitung Total Jenis Barang
$query_jenis = mysqli_query($koneksi, "SELECT COUNT(*) as total_jenis FROM barang");
$data_jenis = mysqli_fetch_assoc($query_jenis);
$total_jenis_barang = $data_jenis['total_jenis'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sarpras MTD</title>
    <link rel="icon" type="image/png" href="assets/jap.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
    /* 1. Background Gambar Full Layar (Space/Luar Angkasa) */
    body {
        background: url('https://images.unsplash.com/photo-1451187580459-43490279c0fa?q=80&w=2072&auto=format&fit=crop') no-repeat center center fixed;
        background-size: cover;
        min-height: 100vh;
    }

    /* 2. Menu Navbar Transparan (Glassmorphism) */
    .navbar {
        background-color: rgba(0, 0, 0, 0.6) !important; /* Hitam Transparan */
        backdrop-filter: blur(15px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        padding-top: 15px;
        padding-bottom: 15px;
    }

    /* 3. LOGIKA MENU */
    .navbar-nav { margin: 0 auto; }
    .nav-item { margin: 0 10px; }
    .nav-link {
        color: rgba(255, 255, 255, 0.8) !important;
        font-weight: 500;
        position: relative;
        transition: all 0.3s ease;
    }

    /* Efek Hover Menu */
    .nav-link:hover {
        color: #00d4ff !important; /* Biru Neon */
        transform: translateY(-3px);
        text-shadow: 0 0 10px rgba(0, 212, 255, 0.5);
    }
    .nav-link::after {
        content: ''; position: absolute; width: 0; height: 2px;
        bottom: 0; left: 50%; background-color: #00d4ff;
        transition: all 0.3s ease; transform: translateX(-50%);
    }
    .nav-link:hover::after { width: 100%; }

    /* Kartu Dashboard */
    .card {
        border: none;
        backdrop-filter: blur(5px);
        background-color: rgba(255, 255, 255, 0.1);
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
    }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">SARPRAS MTD</a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuSaya">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="menuSaya">
                
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="dashboard">Home</a></li>
                    
                    <?php if($_SESSION['level'] == 'admin') { ?>
                        <li class="nav-item"><a class="nav-link" href="barang">Data Barang</a></li>
                        <li class="nav-item"><a class="nav-link" href="peminjaman">Data Peminjam</a></li>
                        <li class="nav-item"><a class="nav-link" href="laporan">Laporan</a></li>
                    <?php } else { ?>
                        <li class="nav-item"><a class="nav-link" href="lihat_barang">Cek Stok Barang</a></li>
                        <li class="nav-item"><a class="nav-link" href="peminjaman">Peminjaman</a></li>
                    <?php } ?>
                </ul>

                <div class="dropdown ms-auto">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        
                        <span class="me-2 d-none d-md-block">Halo, <b><?php echo $_SESSION['username']; ?></b></span>
                        
                        <?php 
                            $foto_profil = "assets/prut.png"; // Default kalau belum ada
                            if(isset($_SESSION['foto']) && $_SESSION['foto'] != ""){
                                $foto_profil = "assets/" . $_SESSION['foto'];
                            }
                        ?>
                        <img src="<?php echo $foto_profil; ?>" alt="user" width="45" height="45" class="rounded-circle border border-2 border-white" style="object-fit: cover;">
                    
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownUser1">
                        <li><div class="dropdown-header">Akun Saya</div></li>
                        
                        <li>
                            <a class="dropdown-item" href="ganti_foto">
                                <span class="fw-bold">📷 Ganti Foto</span>
                            </a>
                        </li>

                        <?php if($_SESSION['level'] == 'admin') { ?>
                            <li>
                                <a class="dropdown-item" href="users">
                                    <span class="fw-bold">👥 Kelola User</span>
                                </a>
                            </li>
                        <?php } ?>

                        <li><hr class="dropdown-divider"></li>
                        
                        <li>
                            <a class="dropdown-item text-danger" href="logout.php">
                                🚪 Logout
                            </a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </nav>

    <div class="container mt-5 pt-5">
        
        <div class="p-5 mb-4 rounded-3 text-white" id="animasi-disini" style="position: relative; overflow: hidden;">
            <div class="container-fluid py-5" style="position: relative; z-index: 2;">
                <h1 class="display-5 fw-bold">Selamat Datang <?php echo isset($_SESSION['nama']) ? $_SESSION['nama'] : 'Admin'; ?>!</h1>
                <p class="col-md-8 fs-4">Belom kelar gua bikin nya.Ntar lagi ya kalo MOOD.</p>
                
                <?php if($_SESSION['level'] == 'admin') { ?>
                    <a href="barang" class="btn btn-outline-light btn-lg">Kelola Data Barang</a>
                <?php } else { ?>
                    <a href="lihat_barang" class="btn btn-outline-light btn-lg">Lihat Stok Barang</a>
                <?php } ?>

            </div>
        </div>
        
        <div class="row">
            
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">Total Jenis Barang</div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $total_jenis_barang; ?> Data</h5>
                        <p class="card-text" style="font-size: 0.8rem;">Jumlah nama barang terdaftar</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Total Stok Unit</div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $total_unit; ?> Unit</h5>
                        <p class="card-text" style="font-size: 0.8rem;">Jumlah fisik seluruh barang</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header">Sedang Dipinjam</div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $sedang_dipinjam; ?> Unit</h5>
                        <p class="card-text" style="font-size: 0.8rem;">Barang yang belum kembali</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r121/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vanta@latest/dist/vanta.waves.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    VANTA.WAVES({
      el: "#animasi-disini", // Pastikan ID ini sesuai sama div di atas
      mouseControls: true,
      touchControls: true,
      gyroControls: false,
      minHeight: 200.00,
      minWidth: 200.00,
      scale: 1.00,
      scaleMobile: 1.00,
      color: 0x144473, // Warna Biru Ombak
      shininess: 50.00,
      waveHeight: 20.00,
      waveSpeed: 0.75,
      zoom: 0.8
    })
});
</script>

</body>
</html>