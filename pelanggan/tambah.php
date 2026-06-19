<?php

include '../config/koneksi.php';

if(isset($_POST['simpan'])){

$id_produk = $_POST['id_produk'];
$id_pelanggan = $_POST['id_pelanggan'];
$id_waktu = $_POST['id_waktu'];
$jumlah = $_POST['jumlah'];

$getHarga = mysqli_fetch_assoc(
mysqli_query(
$conn,
"SELECT harga
FROM dim_produk
WHERE id_produk='$id_produk'"
));

$harga_satuan = $getHarga['harga'];

$total_harga = $jumlah * $harga_satuan;

mysqli_query(
$conn,
"INSERT INTO fact_penjualan
(
id_produk,
id_pelanggan,
id_waktu,
jumlah,
harga_satuan,
total_harga
)
VALUES
(
'$id_produk',
'$id_pelanggan',
'$id_waktu',
'$jumlah',
'$harga_satuan',
'$total_harga'
)"
);

header("Location:index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Tambah Transaksi</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include '../navbar.php'; ?>

<div class="container mt-4">

<h3>Tambah Transaksi</h3>

<form method="POST">

<div class="mb-3">

<label>Produk</label>

<select name="id_produk" class="form-control">

<?php
$produk = mysqli_query($conn,"SELECT * FROM dim_produk");

while($p=mysqli_fetch_assoc($produk)){
?>

<option value="<?= $p['id_produk']; ?>">
<?= $p['nama_produk']; ?>
</option>

<?php } ?>

</select>

</div>

<div class="mb-3">

<label>Pelanggan</label>

<select name="id_pelanggan" class="form-control">

<?php
$pelanggan = mysqli_query($conn,"SELECT * FROM dim_pelanggan");

while($pl=mysqli_fetch_assoc($pelanggan)){
?>

<option value="<?= $pl['id_pelanggan']; ?>">
<?= $pl['nama_pelanggan']; ?>
</option>

<?php } ?>

</select>

</div>

<div class="mb-3">

<label>Tanggal</label>

<select name="id_waktu" class="form-control">

<?php
$waktu = mysqli_query($conn,"SELECT * FROM dim_waktu");

while($w=mysqli_fetch_assoc($waktu)){
?>

<option value="<?= $w['id_waktu']; ?>">
<?= $w['tanggal']; ?>
</option>

<?php } ?>

</select>

</div>

<div class="mb-3">

<label>Jumlah</label>

<input
type="number"
name="jumlah"
class="form-control"
required>

</div>

<button type="submit"
name="simpan"
class="btn btn-success">

Simpan

</button>

<a href="index.php"
class="btn btn-secondary">

Kembali

</a>

</form>

</div>

</body>
</html>