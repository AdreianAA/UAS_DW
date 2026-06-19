<?php

include '../config/koneksi.php';

$id = $_GET['id'];

$data = mysqli_fetch_assoc(
mysqli_query(
$conn,
"SELECT *
FROM fact_penjualan
WHERE id_penjualan='$id'"
)
);

if(isset($_POST['update'])){

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
"UPDATE fact_penjualan SET

id_produk='$id_produk',
id_pelanggan='$id_pelanggan',
id_waktu='$id_waktu',
jumlah='$jumlah',
harga_satuan='$harga_satuan',
total_harga='$total_harga'

WHERE id_penjualan='$id'"
);

header("Location:index.php");
}
?>