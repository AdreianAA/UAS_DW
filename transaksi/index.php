<?php
include '../config/koneksi.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include '../navbar.php'; ?>

<div class="container mt-4">

<h3>Data Transaksi</h3>

<a href="tambah.php" class="btn btn-primary mb-3">
    Tambah Transaksi
</a>

<table class="table table-bordered table-striped">

<thead class="table-dark">
<tr>
    <th>ID</th>
    <th>Produk</th>
    <th>Pelanggan</th>
    <th>Tanggal</th>
    <th>Jumlah</th>
    <th>Harga Satuan</th>
    <th>Total Harga</th>
    <th>Aksi</th>
</tr>
</thead>

<tbody>

<?php

$query = mysqli_query($conn,"
SELECT
f.*,
p.nama_produk,
pl.nama_pelanggan,
w.tanggal

FROM fact_penjualan f

JOIN dim_produk p
ON f.id_produk = p.id_produk

JOIN dim_pelanggan pl
ON f.id_pelanggan = pl.id_pelanggan

JOIN dim_waktu w
ON f.id_waktu = w.id_waktu

ORDER BY f.id_penjualan DESC
");

while($data = mysqli_fetch_assoc($query)){
?>

<tr>

<td><?= $data['id_penjualan']; ?></td>
<td><?= $data['nama_produk']; ?></td>
<td><?= $data['nama_pelanggan']; ?></td>
<td><?= $data['tanggal']; ?></td>
<td><?= $data['jumlah']; ?></td>

<td>
Rp <?= number_format($data['harga_satuan'],0,',','.'); ?>
</td>

<td>
Rp <?= number_format($data['total_harga'],0,',','.'); ?>
</td>

<td>

<a href="edit.php?id=<?= $data['id_penjualan']; ?>"
class="btn btn-warning btn-sm">
Edit
</a>

<a href="hapus.php?id=<?= $data['id_penjualan']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Yakin hapus data?')">
Hapus
</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</body>
</html>