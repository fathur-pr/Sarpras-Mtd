<?php
session_start();
include 'koneksi.php';

// Cek level, cuma Admin yang boleh masuk sini
if ($_SESSION['status'] != "login" || $_SESSION['level'] != 'admin') {
    header("location:dashboard.php");
}

// Logika Tambah User
if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $user = $_POST['username'];
    $pass = md5($_POST['password']); 
    $level = $_POST['level'];
    
    // Simpan ke database
    // Kita sebutkan nama kolomnya satu per satu agar tidak tertukar/error
mysqli_query($koneksi, "INSERT INTO users (nama_lengkap, username, password, level) VALUES ('$nama', '$user', '$pass', '$level')");
    header("location:users.php");
}

// Logika Hapus User
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM users WHERE id='$id'");
    header("location:users.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola User</title>
	<link rel="icon" type="image/png" href="assets/prut.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-light bg-white shadow-sm mb-4">
        <div class="container">
            <span class="navbar-brand mb-0 h1">Manajemen User & Klien</span>
            <a href="dashboard.php" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
    </nav>

    <div class="container">
        
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white">Tambah Akun Baru</div>
            <div class="card-body">
                <form method="POST">
                    <div class="row g-2">
                        <div class="col-md-3">
                            <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" required>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="username" class="form-control" placeholder="Username" required>
                        </div>
                        <div class="col-md-3">
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                        <div class="col-md-2">
                            <select name="level" class="form-control">
                                <option value="petugas">Klien</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <button type="submit" name="simpan" class="btn btn-success w-100">+</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>Username</th>
                            <th>Level</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $data = mysqli_query($koneksi, "SELECT * FROM users ORDER BY id DESC");
                        while ($d = mysqli_fetch_array($data)) {
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $d['nama_lengkap']; ?></td>
                            <td><?php echo $d['username']; ?></td>
                            
                            <td>
                                <span class="badge bg-<?php echo ($d['level'] == 'admin') ? 'danger' : 'info'; ?>">
                                    <?php 
                                        if($d['level'] == 'petugas') {
                                            echo "KLIEN";
                                        } else {
                                            echo "ADMIN";
                                        }
                                    ?>
                                </span>
                            </td>

                            <td>
                                <?php if($d['username'] != 'admin') { ?>
                                    <a href="users?hapus=<?php echo $d['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus user ini?')">Hapus</a>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>