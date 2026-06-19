<?php

include '../config/koneksi.php';

$id = $_GET['id'];

$data = mysqli_fetch_assoc(

    mysqli_query(
        $conn,
        "SELECT * FROM dim_produk
         WHERE id_produk='$id'"
    )
);

if(isset($_POST['update'])){

    $kode_produk = $_POST['kode_produk'];
    $nama_produk = $_POST['nama_produk'];
    $kategori = $_POST['kategori'];
    $harga = $_POST['harga'];

    mysqli_query(
        $conn,
        "UPDATE dim_produk SET

        kode_produk='$kode_produk',
        nama_produk='$nama_produk',
        kategori='$kategori',
        harga='$harga'

        WHERE id_produk='$id'"
    );

    header("Location:index.php");
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Edit Produk</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<?php include '../navbar.php'; ?>

<div class="container mt-4">

<h3>Edit Produk</h3>

<form method="POST">

<div class="mb-3">

<label>Kode Produk</label>

<input type="text"
       name="kode_produk"
       value="<?= $data['kode_produk']; ?>"
       class="form-control">

</div>

<div class="mb-3">

<label>Nama Produk</label>

<input type="text"
       name="nama_produk"
       value="<?= $data['nama_produk']; ?>"
       class="form-control">

</div>

<div class="mb-3">

<label>Kategori</label>

<input type="text"
       name="kategori"
       value="<?= $data['kategori']; ?>"
       class="form-control">

</div>

<div class="mb-3">

<label>Harga</label>

<input type="number"
       name="harga"
       value="<?= $data['harga']; ?>"
       class="form-control">

</div>

<button type="submit"
        name="update"
        class="btn btn-primary">

Update

</button>

<a href="index.php"
   class="btn btn-secondary">

Kembali

</a>

</form>

</div>

</body>
</html>