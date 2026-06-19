<?php
include '../config/koneksi.php';
?>

<!DOCTYPE html>
<html>
<head>

<title>Dimensi Waktu</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<?php include '../navbar.php'; ?>

<div class="container mt-4">

    <h3>Dimensi Waktu</h3>

    <a href="tambah.php"
       class="btn btn-primary mb-3">

       Tambah Tanggal

    </a>

    <table class="table table-bordered table-striped">

        <thead class="table-dark">

        <tr>

            <th>ID</th>
            <th>Tanggal</th>
            <th>Tahun</th>
            <th>Bulan</th>
            <th>Nama Bulan</th>
            <th>Kuartal</th>

        </tr>

        </thead>

        <tbody>

        <?php

        $query = mysqli_query(
            $conn,
            "SELECT *
             FROM dim_waktu
             ORDER BY tanggal DESC"
        );

        while($data = mysqli_fetch_assoc($query)){

        ?>

        <tr>

            <td><?= $data['id_waktu']; ?></td>

            <td><?= $data['tanggal']; ?></td>

            <td><?= $data['tahun']; ?></td>

            <td><?= $data['bulan']; ?></td>

            <td><?= $data['bulan_nama']; ?></td>

            <td>Q<?= $data['kuartal']; ?></td>

        </tr>

        <?php } ?>

        </tbody>

    </table>

</div>

</body>
</html>