<?php

include '../config/koneksi.php';

$id = $_GET['id'];

$data = mysqli_fetch_assoc(

    mysqli_query(
        $conn,
        "SELECT * FROM dim_pelanggan
         WHERE id_pelanggan='$id'"
    )
);

if(isset($_POST['update'])){

    $kode_pelanggan = $_POST['kode_pelanggan'];
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $kota = $_POST['kota'];

    mysqli_query(
        $conn,
        "UPDATE dim_pelanggan SET

        kode_pelanggan='$kode_pelanggan',
        nama_pelanggan='$nama_pelanggan',
        jenis_kelamin='$jenis_kelamin',
        kota='$kota'

        WHERE id_pelanggan='$id'"
    );

    header("Location:index.php");
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Edit Pelanggan</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<?php include '../navbar.php'; ?>

<div class="container mt-4">

<h3>Edit Pelanggan</h3>

<form method="POST">

<div class="mb-3">

<label>Kode Pelanggan</label>

<input type="text"
       name="kode_pelanggan"
       value="<?= $data['kode_pelanggan']; ?>"
       class="form-control">

</div>

<div class="mb-3">

<label>Nama Pelanggan</label>

<input type="text"
       name="nama_pelanggan"
       value="<?= $data['nama_pelanggan']; ?>"
       class="form-control">

</div>

<div class="mb-3">

<label>Jenis Kelamin</label>

<select name="jenis_kelamin"
        class="form-control">

<option value="L"
<?= ($data['jenis_kelamin']=="L") ? "selected" : ""; ?>>
Laki-Laki
</option>

<option value="P"
<?= ($data['jenis_kelamin']=="P") ? "selected" : ""; ?>>
Perempuan
</option>

</select>

</div>

<div class="mb-3">

<label>Kota</label>

<input type="text"
       name="kota"
       value="<?= $data['kota']; ?>"
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