<?php
session_start();
include 'koneksi.php';
if ($_SESSION['status'] != "login") { header("location:index"); }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Barang</title>
    <link rel="icon" type="image/png" href="assets/prut.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
     <style> 
    body {
        /* Ganti link di dalam kurung dengan link gambar GIF pilihanmu */
        background-image: url('https://i.gifer.com/origin/3f/3fcf565ccc553afcfd89858c97304705.gif'); 
        
        /* Agar gambar memenuhi layar */
        background-size: cover;
        
        /* Agar gambar tidak ikut bergerak saat discroll (tetap diam di belakang) */
        background-attachment: fixed;
        
        /* Agar gambar tidak berulang-ulang kecil */
        background-repeat: no-repeat;
        
        /* Posisi gambar di tengah */
        background-position: center;
    }

    /* PENTING: Agar tulisan tabel tetap terbaca */
    /* Kita kasih warna putih transparan di belakang tabel */
    .container, .card {
        background-color: rgba(255, 255, 255, 0.9) !important;
        border-radius: 10px;
        padding: 20px;
        margin-top: 20px;
    }
</style> 
</head>
<body>
    
   <div class="container mt-5">
        
        <h2>Data Inventaris Barang</h2>
        
        <hr>

        <div class="d-flex justify-content-between align-items-center mb-3">
            
            <div>
                <a href="dashboard" class="btn btn-dark">
                    <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                </a>
                
                <a href="tambah" class="btn btn-primary ms-2">
                    Tambah Barang [+]
                </a>
            </div>

            <div>
                <a href="cetak_barang" target="_blank" class="btn btn-danger">
                    <i class="fas fa-file-pdf"></i> Download Data
                </a>
            </div>

        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="tabelBarang">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Tgl Masuk</th> <th>Lokasi</th>
                        <th>Kondisi</th>
                        <th>Stok</th>
                        <th>Aksi</th>
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
                        
                        <td>
                            <?php 
                                // Jika tanggal kosong/null, tampilkan strip
                                if($d['tgl_masuk'] == '0000-00-00' || $d['tgl_masuk'] == null) {
                                    echo "-";
                                } else {
                                    echo date('d-m-Y', strtotime($d['tgl_masuk'])); 
                                }
                            ?>
                        </td>

                        <td><?php echo $d['lokasi']; ?></td>
                        <td>
                            <span class="badge bg-<?php echo ($d['kondisi'] == 'Baik') ? 'success' : 'danger'; ?>">
                                <?php echo $d['kondisi']; ?>
                            </span>
                        </td>
                        <td><?php echo $d['stok']; ?></td>
                        <td>
                            <a href="edit?id=<?php echo $d['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="hapus?id=<?php echo $d['id']; ?>" class="btn btn-danger btn-sm btn-hapus">Hapus</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script>
    // Logika Tombol Hapus dengan Efek Jatuh Tragis
    $(document).on('click', '.btn-hapus', function(e) {
        e.preventDefault();
        var link = $(this).attr('href');

        Swal.fire({
            title: 'Yakin mau di hapus?',
            text: "Kalo Udah Di Apus Ga bisa dibalikin lagi ya!",
            
            // Gambar GIF (Masih pakai Mr Bean, bisa diganti kalo mau)
            imageUrl: 'https://media.giphy.com/media/oe33xf3B50fsc/giphy.gif',
            imageWidth: 200,
            imageHeight: 200,
            imageAlt: 'Custom image',

            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Iya, Hapus Aja!',
            cancelButtonText: 'Gak Jadi Deh',
            reverseButtons: true,
            
            // --- BAGIAN PENTING ---
            preConfirm: () => {
                return new Promise((resolve) => {
                    const popup = Swal.getPopup();
                    
                    // 1. Tempel class animasi yang BARU ('animasi-jatuh')
                    popup.classList.add('animasi-jatuh');
                    
                    // 2. Tunggu 1200ms (1.2 detik) agar animasi selesai baru pindah halaman
                    setTimeout(() => {
                        resolve(true);
                    }, 1200); 
                });
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link;
            }
        })
    });
</script>
    <script>
        $(document).ready(function () {
            $('#tabelBarang').DataTable();
        });
    </script>
</body>
</html>