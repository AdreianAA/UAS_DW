<?php

include '../config/koneksi.php';

if(isset($_POST['simpan'])){

    $tanggal = $_POST['tanggal'];

    $tahun = date(
        'Y',
        strtotime($tanggal)
    );

    $bulan = date(
        'n',
        strtotime($tanggal)
    );

    $bulan_nama = date(
        'F',
        strtotime($tanggal)
    );

    $kuartal = ceil($bulan/3);

    mysqli_query(
        $conn,
        "INSERT INTO dim_waktu
        (
            tanggal,
            tahun,
            bulan,
            bulan_nama,
            kuartal
        )
        VALUES
        (
            '$tanggal',
            '$tahun',
            '$bulan',
            '$bulan_nama',
            '$kuartal'
        )"
    );

    header("Location:index.php");
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Tambah Waktu</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<?php include '../navbar.php'; ?>

<div class="container mt-4">

<h3>Tambah Dimensi Waktu</h3>

<form method="POST">

<div class="mb-3">

<label>Tanggal</label>

<input
type="date"
name="tanggal"
class="form-control"
required>

</div>

<button
type="submit"
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