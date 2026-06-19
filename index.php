<?php
include 'config/koneksi.php';

// Hitung data untuk card dashboard

$jml_produk = mysqli_num_rows(
    mysqli_query($conn, "SELECT * FROM dim_produk")
);

$jml_pelanggan = mysqli_num_rows(
    mysqli_query($conn, "SELECT * FROM dim_pelanggan")
);

$jml_transaksi = mysqli_num_rows(
    mysqli_query($conn, "SELECT * FROM fact_penjualan")
);

$total_penjualan = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT IFNULL(SUM(total_harga),0) as total
         FROM fact_penjualan"
    )
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Warehouse Retail</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background:#f5f7fa;
        }

        .card-dashboard{
            border:none;
            border-radius:15px;
            box-shadow:0 2px 10px rgba(0,0,0,0.1);
        }

        .menu-card{
            transition:0.3s;
            cursor:pointer;
        }

        .menu-card:hover{
            transform:translateY(-5px);
        }

        .judul{
            font-weight:bold;
        }
    </style>

</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container mt-4">

    <div class="text-center mb-5">
        <h2 class="judul">
            Dashboard Utama
        </h2>
        <p>
            Sistem Data Warehouse Toko Retail Online
        </p>
    </div>

    <div class="row">

        <div class="col-md-3 mb-3">
            <div class="card card-dashboard text-center">
                <div class="card-body">
                    <h5>Total Produk</h5>
                    <h2><?= $jml_produk ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card card-dashboard text-center">
                <div class="card-body">
                    <h5>Total Pelanggan</h5>
                    <h2><?= $jml_pelanggan ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card card-dashboard text-center">
                <div class="card-body">
                    <h5>Total Transaksi</h5>
                    <h2><?= $jml_transaksi ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card card-dashboard text-center">
                <div class="card-body">
                    <h5>Total Penjualan</h5>
                    <h5>
                        Rp <?= number_format($total_penjualan['total'],0,',','.') ?>
                    </h5>
                </div>
            </div>
        </div>

    </div>

    <hr class="my-4">

    <h4 class="mb-3">
        Menu Utama
    </h4>

    <div class="row">

        <div class="col-md-3 mb-3">
            <div class="card menu-card">
                <div class="card-body text-center">
                    <h5>Produk</h5>
                    <p>Kelola Data Produk</p>

                    <a href="produk/index.php"
                       class="btn btn-primary">
                        Buka
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card menu-card">
                <div class="card-body text-center">
                    <h5>Pelanggan</h5>
                    <p>Kelola Data Pelanggan</p>

                    <a href="pelanggan/index.php"
                       class="btn btn-success">
                        Buka
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card menu-card">
                <div class="card-body text-center">
                    <h5>Dimensi Waktu</h5>
                    <p>Kelola Data Tanggal</p>

                    <a href="waktu/index.php"
                       class="btn btn-warning">
                        Buka
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card menu-card">
                <div class="card-body text-center">
                    <h5>Transaksi</h5>
                    <p>Kelola Fact Penjualan</p>

                    <a href="transaksi/index.php"
                       class="btn btn-danger">
                        Buka
                    </a>
                </div>
            </div>
        </div>

    </div>

    <div class="row mt-3">

        <div class="col-md-12">
            <div class="card">
                <div class="card-body text-center">

                    <h4>Dashboard Analisis</h4>

                    <p>
                        Menampilkan laporan Data Warehouse,
                        tren penjualan, total penjualan produk,
                        dan pelanggan terbaik.
                    </p>

                    <a href="dashboard/index.php"
                       class="btn btn-dark btn-lg">
                        Buka Dashboard
                    </a>

                </div>
            </div>
        </div>

    </div>

</div>

</body>
</html>