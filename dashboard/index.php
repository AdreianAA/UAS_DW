<?php

include '../config/koneksi.php';

/*
====================================
QUERY 1
TOTAL PENJUALAN PER PRODUK
====================================
*/

$q1 = mysqli_query($conn,"
SELECT
p.nama_produk,
SUM(f.jumlah) AS total_terjual,
SUM(f.total_harga) AS total_pendapatan

FROM fact_penjualan f

JOIN dim_produk p
ON f.id_produk = p.id_produk

GROUP BY p.nama_produk
");

$produk = [];
$pendapatan_produk = [];

while($d=mysqli_fetch_assoc($q1)){

    $produk[] = $d['nama_produk'];
    $pendapatan_produk[] = $d['total_pendapatan'];

}

/*
====================================
QUERY 2
TREN PENJUALAN BULANAN
====================================
*/

$q2 = mysqli_query($conn,"
SELECT
w.bulan_nama,
SUM(f.total_harga) AS total_pendapatan

FROM fact_penjualan f

JOIN dim_waktu w
ON f.id_waktu = w.id_waktu

GROUP BY
w.tahun,
w.bulan

ORDER BY
w.tahun,
w.bulan
");

$bulan = [];
$pendapatan_bulan = [];

while($d=mysqli_fetch_assoc($q2)){

    $bulan[] = $d['bulan_nama'];
    $pendapatan_bulan[] = $d['total_pendapatan'];

}

/*
====================================
QUERY 3
TOP PELANGGAN
====================================
*/

$q3 = mysqli_query($conn,"
SELECT

p.nama_pelanggan,

SUM(f.total_harga)
AS total_belanja,

COUNT(f.id_penjualan)
AS jumlah_transaksi

FROM fact_penjualan f

JOIN dim_pelanggan p
ON f.id_pelanggan = p.id_pelanggan

GROUP BY p.nama_pelanggan

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
        Dashboard Data Warehouse
    </h2>

    <div class="row">

        <div class="col-md-6">

            <div class="card">

                <div class="card-header bg-primary text-white">

                    Total Penjualan per Produk

                </div>

                <div class="card-body">

                    <canvas id="chartProduk"></canvas>

                </div>

            </div>

        </div>

        <div class="col-md-6">

            <div class="card">

                <div class="card-header bg-success text-white">

                    Tren Penjualan per Bulan

                </div>

                <div class="card-body">

                    <canvas id="chartBulan"></canvas>

                </div>

            </div>

        </div>

    </div>

    <br>

    <div class="card">

        <div class="card-header bg-dark text-white">

            Pelanggan Dengan Belanja Tertinggi

        </div>

        <div class="card-body">

            <table class="table table-bordered">

                <thead>

                <tr>

                    <th>No</th>
                    <th>Nama Pelanggan</th>
                    <th>Total Belanja</th>
                    <th>Jumlah Transaksi</th>

                </tr>

                </thead>

                <tbody>

                <?php

                $no=1;

                while($row=mysqli_fetch_assoc($q3)){

                ?>

                <tr>

                    <td><?= $no++ ?></td>

                    <td><?= $row['nama_pelanggan'] ?></td>

                    <td>
                        Rp <?= number_format($row['total_belanja'],0,',','.') ?>
                    </td>

                    <td><?= $row['jumlah_transaksi'] ?></td>

                </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<script>

/*
====================================
BAR CHART PRODUK
====================================
*/

new Chart(
document.getElementById('chartProduk'),
{
    type:'bar',

    data:{

        labels:
        <?= json_encode($produk); ?>,

        datasets:[{

            label:'Pendapatan',

            data:
            <?= json_encode($pendapatan_produk); ?>

        }]
    }
}
);

/*
====================================
LINE CHART BULANAN
====================================
*/

new Chart(
document.getElementById('chartBulan'),
{
    type:'line',

    data:{

        labels:
        <?= json_encode($bulan); ?>,

        datasets:[{

            label:'Pendapatan',

            data:
            <?= json_encode($pendapatan_bulan); ?>,

            fill:false,
            tension:0.3

        }]
    }
}
);

</script>

</body>
</html>