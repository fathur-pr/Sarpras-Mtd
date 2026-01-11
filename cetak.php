<?php
include 'koneksi.php';

// --- LOGIK UNTUK TANGGAL INDONESIA OTOMATIS ---
function tgl_indo($tanggal){
    $bulan = array (
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    );
    $pecahkan = explode('-', $tanggal);
    // Format: tanggal bulan tahun (Contoh: 31 Desember 2025)
    return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}
// ----------------------------------------------

if (isset($_GET['tgl_awal']) && isset($_GET['tgl_akhir'])) {
    $tgl_awal = $_GET['tgl_awal'];
    $tgl_akhir = $_GET['tgl_akhir'];
} else {
    // Kalau user langsung buka file ini tanpa filter, alihkan
    header("location:laporan");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cetak Laporan</title>
    <link rel="icon" type="image/png" href="assets/prut.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; }
        
        /* CSS KHUSUS PRINT */
        @media print {
            .no-print { display: none; }
            
            /* Mencegah tanda tangan terpotong di tengah halaman */
            .signature-section { page-break-inside: avoid; }
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        
        <h3 class="text-center">LAPORAN PEMINJAMAN BARANG</h3>
        <h5 class="text-center">Periode: <?php echo tgl_indo($tgl_awal); ?> s/d <?php echo tgl_indo($tgl_akhir); ?></h5>
        <br>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Peminjam</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Kembali</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                // Query database
                $query = "SELECT peminjaman.*, barang.nama_barang 
                          FROM peminjaman 
                          JOIN barang ON peminjaman.id_barang = barang.id 
                          WHERE tgl_pinjam BETWEEN '$tgl_awal' AND '$tgl_akhir'";
                
                $data = mysqli_query($koneksi, $query);
                
                if(mysqli_num_rows($data) > 0){
                    while ($d = mysqli_fetch_array($data)) {
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $no++; ?></td>
                        <td><?php echo $d['nama_peminjam']; ?></td>
                        <td><?php echo $d['nama_barang']; ?></td>
                        <td class="text-center"><?php echo $d['jumlah']; ?></td>
                        <td><?php echo $d['tgl_pinjam']; ?></td>
                        <td><?php echo ($d['tgl_kembali'] == '0000-00-00') ? '-' : $d['tgl_kembali']; ?></td>
                        <td><?php echo $d['status']; ?></td>
                    </tr>
                    <?php 
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center'>Tidak ada data pada tanggal ini.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <div class="mt-5"></div> <div class="d-flex justify-content-end signature-section">
            <div class="text-center" style="width: 250px;">
                <p class="mb-0">Bojong Gede, <?php echo tgl_indo(date('Y-m-d')); ?></p>
                
                <p class="mb-0">Mengetahui,</p>
                <p>Waka.Sarpras</p>
                
                <br><br><br> <p class="fw-bold"><u>IIIIIIIS</u></p>
            </div>
        </div>

    </div>

    <script>
        // Script ini otomatis memunculkan dialog print saat halaman dibuka
        window.print();
    </script>
</body>
</html>