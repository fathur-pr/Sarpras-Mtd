<?php
session_start();
include 'koneksi.php';
if ($_SESSION['status'] != "login") { header("location:index"); }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Peminjaman</title>
    <link rel="icon" type="image/png" href="assets/prut.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Transaksi Peminjaman</h2>
        <hr>
        <a href="dashboard" class="btn btn-secondary mb-3">Kembali</a>
        
        <?php if($_SESSION['level'] == 'admin') { ?>
            <a href="pinjam" class="btn btn-primary mb-3">Tambah Peminjaman Baru</a>
        <?php } ?>

        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Peminjam</th>
                    <th>Nama Barang</th>
                    <th>Jml</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Kembali</th>
                    <th>Status</th>
                    
                    <?php if($_SESSION['level'] == 'admin') { ?>
                        <th>Aksi</th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $data = mysqli_query($koneksi, "SELECT peminjaman.*, barang.nama_barang 
                                                FROM peminjaman 
                                                JOIN barang ON peminjaman.id_barang = barang.id 
                                                ORDER BY peminjaman.id DESC");
                while ($d = mysqli_fetch_array($data)) {
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $d['nama_peminjam']; ?></td>
                    <td><?php echo $d['nama_barang']; ?></td>
                    <td><?php echo $d['jumlah']; ?></td>
                    <td><?php echo $d['tgl_pinjam']; ?></td>
                    <td><?php echo ($d['tgl_kembali'] == '0000-00-00') ? '-' : $d['tgl_kembali']; ?></td>
                    <td>
                        <span class="badge bg-<?php echo ($d['status'] == 'Dipinjam') ? 'warning' : 'success'; ?>">
                            <?php echo $d['status']; ?>
                        </span>
                    </td>
                    
                    <?php if($_SESSION['level'] == 'admin') { ?>
                    <td>
                        <?php if($d['status'] == 'Dipinjam') { ?>
                            <a href="#" 
                               onclick="konfirmasiSelesai('kembali?id=<?php echo $d['id']; ?>'); return false;" 
                               class="btn btn-success btn-sm">Selesai/Kembali</a>
                        <?php } else { echo "Selesai"; } ?>
                    </td>
                    <?php } ?>
                    
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    // --- NOTIFIKASI KONFIRMASI ---
    function konfirmasiSelesai(urlTujuan) {
        Swal.fire({
            title: 'Udah Selesai Minjem Nya?',
            text: "Mau Di Balikin Sekarang?",
            icon: 'question',
            background: '#fff3cd',   
            color: '#856404',        
            iconColor: '#856404',
            showCancelButton: true,
            confirmButtonColor: '#ffc107',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Iya, Nannya Mulu!',
            cancelButtonText: 'Gajadi Deh',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = urlTujuan;
            }
        })
    }
    </script>

    <?php if (isset($_SESSION['info']) && $_SESSION['info'] == 'sukses'): ?>
    <script>
        Swal.fire({
            title: "Mantapppp",
            text: "Barang Udah Dibalikin",
            icon: 'success', // Icon saya ganti success biar muncul centang hijau
            background: '#d1e7dd',   
            color: '#0f5132',
            iconColor: '#0f5132',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        });
    </script>
    <?php unset($_SESSION['info']); ?>
    <?php endif; ?>
</body>
</html>