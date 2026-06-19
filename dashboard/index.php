<?php
include '../config/koneksi.php';

/*
====================================
QUERY 1
TOTAL PENJUALAN PER PRODUK
====================================
*/

$q_produk = mysqli_query($conn,"
SELECT
    p.nama_produk,
    SUM(f.total_harga) AS total_pendapatan
FROM fact_penjualan f
INNER JOIN dim_produk p
ON f.id_produk = p.id_produk
GROUP BY p.id_produk, p.nama_produk
ORDER BY total_pendapatan DESC
");

$produk = [];
$pendapatan_produk = [];

while($row = mysqli_fetch_assoc($q_produk)){
    $produk[] = $row['nama_produk'];
    $pendapatan_produk[] = $row['total_pendapatan'];
}

/*
====================================
QUERY 2
TREN PENJUALAN BULANAN
====================================
*/

$q_bulan = mysqli_query($conn,"
SELECT
    w.bulan,
    w.bulan_nama,
    SUM(f.total_harga) AS total_pendapatan
FROM fact_penjualan f
INNER JOIN dim_waktu w
ON f.id_waktu = w.id_waktu
GROUP BY w.bulan, w.bulan_nama
ORDER BY w.bulan
");

$bulan = [];
$pendapatan_bulan = [];

while($row = mysqli_fetch_assoc($q_bulan)){
    $bulan[] = $row['bulan_nama'];
    $pendapatan_bulan[] = $row['total_pendapatan'];
}

/*
====================================
QUERY 3
TOP PELANGGAN
====================================
*/

$q_pelanggan = mysqli_query($conn,"
SELECT
    p.nama_pelanggan,
    SUM(f.total_harga) AS total_belanja,
    COUNT(f.id_penjualan) AS jumlah_transaksi
FROM fact_penjualan f
INNER JOIN dim_pelanggan p
ON f.id_pelanggan = p.id_pelanggan
GROUP BY p.id_pelanggan, p.nama_pelanggan
ORDER BY total_belanja DESC
");
?>

<!DOCTYPE html>
<html>
<head>

    <title>Dashboard Data Warehouse</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>

<?php include '../navbar.php'; ?>

<div class="container mt-4">

    <h2 class="mb-4">
        Dashboard Data Warehouse Retail
    </h2>

    <div class="row">

        <div class="col-md-6 mb-4">

            <div class="card shadow">

                <div class="card-header bg-primary text-white">
                    Total Penjualan per Produk
                </div>

                <div class="card-body">

                    <canvas id="chartProduk"></canvas>

                </div>

            </div>

        </div>

        <div class="col-md-6 mb-4">

            <div class="card shadow">

                <div class="card-header bg-success text-white">
                    Tren Penjualan Bulanan
                </div>

                <div class="card-body">

                    <canvas id="chartBulan"></canvas>

                </div>

            </div>

        </div>

    </div>

    <div class="card shadow">

        <div class="card-header bg-dark text-white">
            Pelanggan Dengan Belanja Tertinggi
        </div>

        <div class="card-body">

            <table class="table table-bordered table-striped">

                <thead class="table-dark">

                <tr>
                    <th>No</th>
                    <th>Nama Pelanggan</th>
                    <th>Total Belanja</th>
                    <th>Jumlah Transaksi</th>
                </tr>

                </thead>

                <tbody>

                <?php
                $no = 1;

                while($row = mysqli_fetch_assoc($q_pelanggan)){
                ?>

                <tr>

                    <td><?= $no++; ?></td>

                    <td><?= $row['nama_pelanggan']; ?></td>

                    <td>
                        Rp <?= number_format($row['total_belanja'],0,',','.'); ?>
                    </td>

                    <td>
                        <?= $row['jumlah_transaksi']; ?>
                    </td>

                </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<script>

/*
=================================
GRAFIK PRODUK
=================================
*/

new Chart(
document.getElementById('chartProduk'),
{
    type: 'bar',

    data: {

        labels:
        <?= json_encode($produk); ?>,

        datasets: [{

            label: 'Total Pendapatan',

            data:
            <?= json_encode($pendapatan_produk); ?>,

            borderWidth: 1

        }]
    },

    options: {
        responsive: true
    }
}
);

/*
=================================
GRAFIK BULANAN
=================================
*/

new Chart(
document.getElementById('chartBulan'),
{
    type: 'line',

    data: {

        labels:
        <?= json_encode($bulan); ?>,

        datasets: [{

            label: 'Pendapatan',

            data:
            <?= json_encode($pendapatan_bulan); ?>,

            borderWidth: 2,
            tension: 0.3
        }]
    },

    options: {
        responsive: true
    }
}
);

</script>

</body>
</html>