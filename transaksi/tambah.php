<?php

include '../config/koneksi.php';

if(isset($_POST['simpan'])){

    $kode_pelanggan = $_POST['kode_pelanggan'];
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $kota = $_POST['kota'];

    mysqli_query(
        $conn,
        "INSERT INTO dim_pelanggan
        (
            kode_pelanggan,
            nama_pelanggan,
            jenis_kelamin,
            kota
        )
        VALUES
        (
            '$kode_pelanggan',
            '$nama_pelanggan',
            '$jenis_kelamin',
            '$kota'
        )"
    );

    header("Location:index.php");
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Tambah Pelanggan</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<?php include '../navbar.php'; ?>

<div class="container mt-4">

<h3>Tambah Pelanggan</h3>

<form method="POST">

<div class="mb-3">
<label>Kode Pelanggan</label>

<input type="text"
       name="kode_pelanggan"
       class="form-control"
       required>
</div>

<div class="mb-3">
<label>Nama Pelanggan</label>

<input type="text"
       name="nama_pelanggan"
       class="form-control"
       required>
</div>

<div class="mb-3">

<label>Jenis Kelamin</label>

<select name="jenis_kelamin"
        class="form-control">

<option value="L">Laki-Laki</option>
<option value="P">Perempuan</option>

</select>

</div>

<div class="mb-3">

<label>Kota</label>

<input type="text"
       name="kota"
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