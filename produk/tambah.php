<?php
include '../config/koneksi.php';

if(isset($_POST['simpan'])){

    $kode_produk = $_POST['kode_produk'];
    $nama_produk = $_POST['nama_produk'];
    $kategori = $_POST['kategori'];
    $harga = $_POST['harga'];

    mysqli_query(
        $conn,
        "INSERT INTO dim_produk
        (
            kode_produk,
            nama_produk,
            kategori,
            harga
        )
        VALUES
        (
            '$kode_produk',
            '$nama_produk',
            '$kategori',
            '$harga'
        )"
    );

    header("Location:index.php");
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Tambah Produk</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<?php include '../navbar.php'; ?>

<div class="container mt-4">

<h3>Tambah Produk</h3>

<form method="POST">

<div class="mb-3">

<label>Kode Produk</label>

<input type="text"
       name="kode_produk"
       class="form-control"
       required>

</div>

<div class="mb-3">

<label>Nama Produk</label>

<input type="text"
       name="nama_produk"
       class="form-control"
       required>

</div>

<div class="mb-3">

<label>Kategori</label>

<select name="kategori"
        class="form-control">

<option>Elektronik</option>
<option>Pakaian</option>
<option>Makanan</option>
<option>Aksesoris</option>

</select>

</div>

<div class="mb-3">

<label>Harga</label>

<input type="number"
       name="harga"
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