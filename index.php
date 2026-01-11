<?php
// === 1. SETTING SESI ABADI (24 Jam) ===
// Biar kalau browser ditutup, pas dibuka lagi masih login (gak terkunci)
ini_set('session.gc_maxlifetime', 86400);
session_set_cookie_params(86400);
session_start();

// === 2. AUTO REDIRECT ===
// Kalau di browser masih ada sesi login, langsung lempar ke dashboard
if(isset($_SESSION['status']) && $_SESSION['status'] == "login"){
    header("location:dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Aplikasi Sarpras MTD</title>
    <link rel="icon" type="image/png" href="assets/prut.png">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* === BACKGROUND VIDEO === */
        .video-background-container {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            overflow: hidden;
            z-index: -100; /* Pastikan di paling belakang */
        }
        #bgVideo {
            position: absolute;
            top: 50%; left: 50%;
            min-width: 100%; min-height: 100%;
            width: auto; height: auto;
            transform: translateX(-50%) translateY(-50%);
            object-fit: cover;
            filter: blur(3px); /* Efek Blur dikit biar estetik */
        }
        /* Lapisan gelap biar teks tetap terbaca */
        .video-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Gelap transparan */
            z-index: -99;
        }

        body {
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            display: flex; justify-content: center; align-items: center;
            margin: 0;
            background-color: #333; /* Warna cadangan kalau video gagal loading */
        }

        .login-card {
            width: 100%; max-width: 420px;
            padding: 40px;
            border-radius: 15px;
            /* Efek Kaca (Glassmorphism) */
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        }
        
        /* Input Custom */
        .form-control {
            border-radius: 10px; padding: 12px;
            background-color: #f8f9fa; border: 1px solid #ddd;
        }
        .form-control:focus {
            box-shadow: none; border-color: #0d6efd; background-color: #fff;
        }

        /* Tombol Custom */
        .btn-primary {
            border-radius: 10px; padding: 12px; font-weight: 600;
            letter-spacing: 1px; transition: all 0.3s ease;
            text-transform: uppercase;
        }
        .btn-primary:hover {
             transform: translateY(-3px);
             box-shadow: 0 5px 15px rgba(13, 110, 253, 0.4);
        }
    </style>
</head>
<body>

    <div class="video-background-container">
        <video autoplay muted loop id="bgVideo">
            <source src="assets/oke.mp4" type="video/mp4">
        </video>
    </div>
    <div class="video-overlay"></div>

    <div class="login-card text-center">
        
        <h3 class="mb-2 fw-bold text-dark">Aplikasi Sarpras</h3>
        <h4 class="mb-4 fw-bold text-dark">MTD</h4>
        
        <?php 
        if(isset($_GET['pesan'])){
            if($_GET['pesan'] == "gagal"){
                echo "<div class='alert alert-danger p-2 small'>Username atau Password salah!</div>";
            }
            else if($_GET['pesan'] == "belum_login"){
                echo "<div class='alert alert-warning p-2 small'>Silahkan login dulu ya.</div>";
            }
            else if($_GET['pesan'] == "sedang_login"){
                echo "<div class='alert alert-warning p-2 small border-warning' style='background-color: #fff3cd; color: #856404;'>
                        <strong>Akses Ditolak!</strong><br>Akun ini sedang digunakan di perangkat lain.
                      </div>";
            }
            // Pesan logout sudah dihapus dari sini
        }
        ?>

        <form action="cek_login" method="post" class="text-start">
            <div class="mb-3">
                <label class="form-label text-muted small">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Input yang bener" required>
            </div>
            <div class="mb-3">
                 <label class="form-label text-muted small">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Jangan Sampe Salah" required>
            </div>
            
            <div class="mb-4 text-end">
                <a href="https://wa.me/6287882889585?text=Halo%20AA FATUR GANTENG,%20Saya%20Lupa%20Password%20Akun%20Sarpras" target="_blank" class="text-decoration-none text-muted small">
                    Password Inget ga?
                </a>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">MASUK BURUAN</button>
            </div>
        </form>
    </div>

</body>
</html>